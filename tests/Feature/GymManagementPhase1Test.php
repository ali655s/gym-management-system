<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\ContactMessage;
use App\Models\FranchiseApplication;
use App\Models\GymClass;
use App\Models\Member;
use App\Models\MembershipPlan;
use App\Models\Partner;
use App\Models\Subscription;
use App\Models\Trainer;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class GymManagementPhase1Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Register a test route to verify admin middleware
        Route::middleware(['web', 'admin'])->get('/test-admin-only', function () {
            return response()->json(['status' => 'success', 'message' => 'Welcome Admin']);
        });
    }

    public function test_admin_user_seeded_properly_and_identified(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = User::where('email', 'admin@gym.com')->first();
        $this->assertNotNull($admin);
        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isMember());
        $this->assertTrue(Hash::check('password123', $admin->password));
    }

    public function test_member_row_is_automatically_created_when_member_user_is_created(): void
    {
        $user = User::create([
            'name' => 'Alice Member',
            'email' => 'alice@gym.com',
            'password' => Hash::make('secret123'),
            'role' => 'member',
        ]);

        $this->assertTrue($user->isMember());
        $this->assertFalse($user->isAdmin());
        $this->assertNotNull($user->member);
        $this->assertEquals($user->id, $user->member->user_id);
    }

    public function test_admin_user_does_not_auto_create_member_row(): void
    {
        $admin = User::create([
            'name' => 'Bob Admin',
            'email' => 'bob@gym.com',
            'password' => Hash::make('secret123'),
            'role' => 'admin',
        ]);

        $this->assertTrue($admin->isAdmin());
        $this->assertNull($admin->member);
    }

    public function test_admin_middleware_allows_admin_user(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/test-admin-only');
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_admin_middleware_denies_member_user(): void
    {
        $memberUser = User::factory()->create([
            'role' => 'member',
        ]);

        $response = $this->actingAs($memberUser)->get('/test-admin-only');
        $response->assertStatus(403);
    }

    public function test_admin_middleware_denies_guest(): void
    {
        $response = $this->get('/test-admin-only');
        $response->assertStatus(403);
    }

    public function test_subscription_end_date_and_amount_are_automatically_calculated(): void
    {
        $branch = Branch::create([
            'name' => 'Test Branch',
            'city' => 'Cairo',
            'address' => 'Test Address',
            'phone' => '12345678',
        ]);

        $plan1m = MembershipPlan::create([
            'branch_id' => $branch->id,
            'duration' => '1_month',
            'price' => 50.00,
        ]);

        $plan3m = MembershipPlan::create([
            'branch_id' => $branch->id,
            'duration' => '3_months',
            'price' => 130.00,
        ]);

        $plan6m = MembershipPlan::create([
            'branch_id' => $branch->id,
            'duration' => '6_months',
            'price' => 240.00,
        ]);

        $user = User::create([
            'name' => 'Charlie Member',
            'email' => 'charlie@gym.com',
            'password' => Hash::make('secret123'),
            'role' => 'member',
        ]);
        $member = $user->member;

        // Test 1-month auto calculation
        $startDate = '2026-01-01';
        $sub1 = Subscription::create([
            'member_id' => $member->id,
            'membership_plan_id' => $plan1m->id,
            'start_date' => $startDate,
        ]);

        $this->assertEquals('2026-02-01', $sub1->end_date->format('Y-m-d'));
        $this->assertEquals('50.00', $sub1->amount_paid);

        // Test 3-months auto calculation
        $sub3 = Subscription::create([
            'member_id' => $member->id,
            'membership_plan_id' => $plan3m->id,
            'start_date' => $startDate,
        ]);
        $this->assertEquals('2026-04-01', $sub3->end_date->format('Y-m-d'));
        $this->assertEquals('130.00', $sub3->amount_paid);

        // Test 6-months auto calculation
        $sub6 = Subscription::create([
            'member_id' => $member->id,
            'membership_plan_id' => $plan6m->id,
            'start_date' => $startDate,
        ]);
        $this->assertEquals('2026-07-01', $sub6->end_date->format('Y-m-d'));
        $this->assertEquals('240.00', $sub6->amount_paid);
    }

    public function test_subscription_renewal_when_active_starts_from_old_end_date(): void
    {
        $branch = Branch::create([
            'name' => 'Downtown Branch',
            'city' => 'Cairo',
            'address' => 'Center',
            'phone' => '12345678',
        ]);

        $plan = MembershipPlan::create([
            'branch_id' => $branch->id,
            'duration' => '1_month',
            'price' => 60.00,
        ]);

        $user = User::create([
            'name' => 'Dan Member',
            'email' => 'dan@gym.com',
            'password' => Hash::make('secret123'),
            'role' => 'member',
        ]);
        $member = $user->member;

        // Current active subscription ending 10 days in the future
        $currentStart = Carbon::today()->subDays(20)->toDateString();
        $currentEnd = Carbon::today()->addDays(10)->toDateString();

        $activeSub = Subscription::create([
            'member_id' => $member->id,
            'membership_plan_id' => $plan->id,
            'start_date' => $currentStart,
            'end_date' => $currentEnd,
            'status' => 'active',
            'amount_paid' => 60.00,
        ]);

        // Renew the subscription
        $newSub = $activeSub->renew();

        // Check that old subscription is now marked expired
        $activeSub->refresh();
        $this->assertEquals('expired', $activeSub->status);

        // Check new subscription starts exactly from old end_date
        $this->assertEquals($currentEnd, $newSub->start_date->format('Y-m-d'));
        $this->assertEquals('active', $newSub->status);
        $expectedNewEnd = Carbon::parse($currentEnd)->addMonth()->toDateString();
        $this->assertEquals($expectedNewEnd, $newSub->end_date->format('Y-m-d'));
    }

    public function test_subscription_renewal_when_expired_starts_from_today(): void
    {
        $branch = Branch::create([
            'name' => 'Downtown Branch',
            'city' => 'Cairo',
            'address' => 'Center',
            'phone' => '12345678',
        ]);

        $plan = MembershipPlan::create([
            'branch_id' => $branch->id,
            'duration' => '1_month',
            'price' => 60.00,
        ]);

        $user = User::create([
            'name' => 'Eve Member',
            'email' => 'eve@gym.com',
            'password' => Hash::make('secret123'),
            'role' => 'member',
        ]);
        $member = $user->member;

        // Subscription that expired 15 days ago
        $expiredStart = Carbon::today()->subDays(45)->toDateString();
        $expiredEnd = Carbon::today()->subDays(15)->toDateString();

        $expiredSub = Subscription::create([
            'member_id' => $member->id,
            'membership_plan_id' => $plan->id,
            'start_date' => $expiredStart,
            'end_date' => $expiredEnd,
            'status' => 'expired',
            'amount_paid' => 60.00,
        ]);

        // Renew expired subscription
        $newSub = $expiredSub->renew();

        // Check new subscription starts from today
        $this->assertEquals(Carbon::today()->toDateString(), $newSub->start_date->format('Y-m-d'));
        $this->assertEquals('active', $newSub->status);
        $expectedEnd = Carbon::today()->addMonth()->toDateString();
        $this->assertEquals($expectedEnd, $newSub->end_date->format('Y-m-d'));
    }

    public function test_member_renew_subscription_helper_method(): void
    {
        $branch = Branch::create([
            'name' => 'Test Branch',
            'city' => 'Cairo',
            'address' => 'Center',
            'phone' => '12345678',
        ]);

        $plan1 = MembershipPlan::create([
            'branch_id' => $branch->id,
            'duration' => '1_month',
            'price' => 60.00,
        ]);

        $plan3 = MembershipPlan::create([
            'branch_id' => $branch->id,
            'duration' => '3_months',
            'price' => 150.00,
        ]);

        $user = User::create([
            'name' => 'Frank Member',
            'email' => 'frank@gym.com',
            'password' => Hash::make('secret123'),
            'role' => 'member',
        ]);
        $member = $user->member;

        // Member renews with a 3-month plan directly
        $sub = $member->renewSubscription($plan3);

        $this->assertEquals(Carbon::today()->toDateString(), $sub->start_date->format('Y-m-d'));
        $this->assertEquals(Carbon::today()->addMonths(3)->toDateString(), $sub->end_date->format('Y-m-d'));
        $this->assertEquals('150.00', $sub->amount_paid);
        $this->assertTrue($member->hasActiveSubscription());
    }

    public function test_testimonials_config_exists_and_contains_items(): void
    {
        $testimonials = config('testimonials.items');

        $this->assertIsArray($testimonials);
        $this->assertNotEmpty($testimonials);

        foreach ($testimonials as $testimonial) {
            $this->assertArrayHasKey('name', $testimonial);
            $this->assertArrayHasKey('quote', $testimonial);
            $this->assertArrayHasKey('rating', $testimonial);
            $this->assertArrayHasKey('branch', $testimonial);
        }
    }

    public function test_database_seeder_creates_all_specified_records(): void
    {
        $this->seed(DatabaseSeeder::class);

        // 1 admin
        $this->assertEquals(1, User::where('role', 'admin')->count());
        $admin = User::where('email', 'admin@gym.com')->first();
        $this->assertNotNull($admin);

        // 3 branches
        $this->assertEquals(3, Branch::count());

        // 3 membership plans per branch (total 9)
        $this->assertEquals(9, MembershipPlan::count());
        foreach (Branch::all() as $branch) {
            $this->assertEquals(3, $branch->membershipPlans()->count());
        }

        // 2 classes per branch (total 6)
        $this->assertEquals(6, GymClass::count());
        foreach (Branch::all() as $branch) {
            $this->assertEquals(2, $branch->gymClasses()->count());
            $this->assertTrue($branch->gymClasses()->where('name', 'Zumba')->exists());
            $this->assertTrue($branch->gymClasses()->where('name', 'CrossFit')->exists());
        }

        // 3 trainers
        $this->assertEquals(3, Trainer::count());

        // 1 test member with active subscription
        $memberUser = User::where('email', 'member@gym.com')->first();
        $this->assertNotNull($memberUser);
        $this->assertNotNull($memberUser->member);
        $this->assertTrue($memberUser->member->hasActiveSubscription());

        // Partners seeded
        $this->assertEquals(3, Partner::count());
    }

    public function test_franchise_application_and_contact_message_policies(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $member = User::factory()->create(['role' => 'member']);

        $application = FranchiseApplication::create([
            'full_name' => 'Applicant One',
            'email' => 'applicant@gmail.com',
            'phone' => '0101010101',
            'city' => 'Cairo',
            'capital' => '500,000 EGP',
            'message' => 'Interested in opening a franchise.',
        ]);

        $message = ContactMessage::create([
            'name' => 'Visitor',
            'email' => 'visitor@gmail.com',
            'message' => 'Hello, what are your opening hours?',
        ]);

        // Policies allow admin to update
        $this->assertTrue(Gate::forUser($admin)->allows('update', $application));
        $this->assertTrue(Gate::forUser($admin)->allows('update', $message));

        // Policies forbid non-admin from updating
        $this->assertFalse(Gate::forUser($member)->allows('update', $application));
        $this->assertFalse(Gate::forUser($member)->allows('update', $message));

        // Model helper methods
        $application->approve();
        $this->assertEquals('approved', $application->fresh()->status);

        $message->markAsRead();
        $this->assertTrue($message->fresh()->is_read);
    }
}
