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
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GymManagementPhase2Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_home_page_loads_with_trainers_partners_and_stats(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('IRONPULSE');
        $response->assertSee('Marcus Stone');
        $response->assertSee('Elena Rostova');
        $response->assertSee('David Miller');
        $response->assertSee('Gymshark');
        $response->assertSee('Downtown Flagship');
    }

    public function test_memberships_page_displays_branches_plans_and_classes(): void
    {
        $response = $this->get('/memberships');
        $response->assertStatus(200);
        $response->assertSee('Downtown Flagship');
        $response->assertSee('Seaside Arena');
        $response->assertSee('Oasis Health Club');
        $response->assertSee('Zumba');
        $response->assertSee('CrossFit');
        $response->assertSee('Subscribe Now');
    }

    public function test_guest_subscribing_redirects_to_login(): void
    {
        $plan = MembershipPlan::first();

        $response = $this->get(route('memberships.checkout', $plan->id));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_member_can_checkout_and_subscribe(): void
    {
        $memberUser = User::where('email', 'member@gym.com')->first();
        $plan = MembershipPlan::where('duration', '3_months')->first();

        // 1. Visit checkout page
        $response = $this->actingAs($memberUser)->get(route('memberships.checkout', $plan->id));
        $response->assertStatus(200);
        $response->assertSeeText('CONFIRM YOUR MEMBERSHIP');
        $response->assertSee('Activate Subscription');

        // 2. Submit subscription confirmation
        $postResponse = $this->actingAs($memberUser)->post(route('memberships.subscribe', $plan->id));
        $postResponse->assertRedirect(route('member.memberships'));
        $postResponse->assertSessionHas('success');

        // Verify in database
        $this->assertDatabaseHas('subscriptions', [
            'member_id' => $memberUser->member->id,
            'membership_plan_id' => $plan->id,
            'status' => 'active',
        ]);
    }

    public function test_franchise_page_loads_and_form_submission_stores_data(): void
    {
        // 1. Check page loads
        $response = $this->get(route('franchise.index'));
        $response->assertStatus(200);
        $response->assertSee('FRANCHISE APPLICATION FORM');

        // 2. Validation failure test
        $invalidResponse = $this->post(route('franchise.store'), []);
        $invalidResponse->assertSessionHasErrors(['full_name', 'email', 'phone', 'city', 'capital']);

        // 3. Successful submission test
        $validData = [
            'full_name' => 'Kareem Nabil',
            'email' => 'kareem@franchise.com',
            'phone' => '+20 10 1122 3344',
            'city' => 'New Cairo',
            'capital' => '$250,000 - $400,000',
            'message' => 'Looking to secure territorial rights in 5th Settlement.',
        ];

        $postResponse = $this->post(route('franchise.store'), $validData);
        $postResponse->assertRedirect(route('franchise.index'));
        $postResponse->assertSessionHas('success');

        $this->assertDatabaseHas('franchise_applications', [
            'email' => 'kareem@franchise.com',
            'city' => 'New Cairo',
            'status' => 'pending',
        ]);
    }

    public function test_contact_page_loads_and_message_submission_stores_data(): void
    {
        // 1. Check contact page loads
        $response = $this->get(route('contact.index'));
        $response->assertStatus(200);
        $response->assertSee('CONNECT WITH IRONPULSE');

        // 2. Validation failure test
        $invalidResponse = $this->post(route('contact.store'), []);
        $invalidResponse->assertSessionHasErrors(['name', 'email', 'message']);

        // 3. Successful submission test
        $validData = [
            'name' => 'Salma Ezzat',
            'email' => 'salma@gmail.com',
            'message' => 'Do you have female-only hours for the Zumba classes in Alexandria?',
        ];

        $postResponse = $this->post(route('contact.store'), $validData);
        $postResponse->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'salma@gmail.com',
            'is_read' => false,
        ]);
    }

    public function test_member_can_view_my_memberships_and_renew_subscription(): void
    {
        $memberUser = User::where('email', 'member@gym.com')->first();
        $subscription = $memberUser->member->activeSubscription;

        $response = $this->actingAs($memberUser)->get(route('member.memberships'));
        $response->assertStatus(200);
        $response->assertSee('MY MEMBERSHIPS');
        $response->assertSee($subscription->membershipPlan->branch->name);

        // Renew subscription
        $renewResponse = $this->actingAs($memberUser)->post(route('subscriptions.renew', $subscription->id));
        $renewResponse->assertRedirect(route('member.memberships'));
        $renewResponse->assertSessionHas('success');

        // Old subscription should be marked expired
        $this->assertEquals('expired', $subscription->fresh()->status);

        // Member should have a new active subscription
        $this->assertEquals(2, $memberUser->member->subscriptions()->count());
    }

    public function test_member_cannot_renew_another_members_subscription(): void
    {
        $userA = User::where('email', 'member@gym.com')->first();
        $subA = $userA->member->activeSubscription;

        // Create user B
        $userB = User::create([
            'name' => 'Stranger',
            'email' => 'stranger@gym.com',
            'password' => bcrypt('password123'),
            'role' => 'member',
        ]);

        // User B attempts to renew User A's subscription
        $response = $this->actingAs($userB)->post(route('subscriptions.renew', $subA->id));
        $response->assertStatus(403);
    }

    public function test_member_can_update_profile_including_phone_and_photo(): void
    {
        Storage::fake('public');

        $user = User::where('email', 'member@gym.com')->first();
        $photo = UploadedFile::fake()->create('avatar.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'John Updated',
            'email' => 'john.updated@gym.com',
            'phone' => '+20 12 9999 8888',
            'image' => $photo,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('profile.edit'));

        $user->refresh();
        $this->assertEquals('John Updated', $user->name);
        $this->assertEquals('+20 12 9999 8888', $user->phone);
        $this->assertNotNull($user->image);

        // Verify photo exists in public disk
        Storage::disk('public')->assertExists($user->image);
    }
}
