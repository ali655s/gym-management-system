<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Member;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminPhase3Test extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an admin user
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($this->admin);
    }

    #[Test]
    public function non_admin_cannot_access_admin_routes()
    {
        $member = User::factory()->create(['role' => 'member']);
        $this->actingAs($member);
        $response = $this->get(route('admin.dashboard'));
        $response->assertForbidden();
    }

    #[Test]
    public function admin_can_view_members_index_and_search()
    {
        $branch = Branch::factory()->create();
        $memberUser = User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
        $member = Member::factory()->create(['user_id' => $memberUser->id, 'branch_id' => $branch->id]);

        $response = $this->get(route('admin.members.index'));
        $response->assertOk();
        $response->assertSee('John Doe');

        $response = $this->get(route('admin.members.index', ['search' => 'john']));
        $response->assertOk();
        $response->assertSee('John Doe');
    }

    #[Test]
    public function admin_can_update_member_branch()
    {
        $branch1 = Branch::factory()->create();
        $branch2 = Branch::factory()->create();
        $memberUser = User::factory()->create();
        $member = Member::factory()->create(['user_id' => $memberUser->id, 'branch_id' => $branch1->id]);

        $response = $this->put(route('admin.members.update', $member), ['branch_id' => $branch2->id]);
        $response->assertRedirect();
        $this->assertDatabaseHas('members', ['id' => $member->id, 'branch_id' => $branch2->id]);
    }

    #[Test]
    public function admin_cannot_demote_self_and_cannot_delete_self()
    {
        // Attempt to demote self
        $response = $this->put(route('admin.users.update', $this->admin), [
            'name' => $this->admin->name,
            'email' => $this->admin->email,
            'role' => 'member',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $this->admin->id, 'role' => 'admin']);

        // Attempt to delete self
        $response = $this->delete(route('admin.users.destroy', $this->admin));
        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    #[Test]
    public function admin_can_create_and_edit_other_user()
    {
        $response = $this->post(route('admin.users.store'), [
            'name' => 'New Admin',
            'email' => 'newadmin@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'admin',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['email' => 'newadmin@example.com', 'role' => 'admin']);

        $newUser = User::where('email', 'newadmin@example.com')->first();
        $response = $this->put(route('admin.users.update', $newUser), [
            'name' => 'Updated Admin',
            'email' => 'newadmin@example.com',
            'role' => 'member',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $newUser->id, 'role' => 'member']);
    }

    #[Test]
    public function admin_can_view_and_filter_subscriptions()
    {
        $branch = Branch::factory()->create();
        $plan = \App\Models\MembershipPlan::factory()->create(['branch_id' => $branch->id]);
        $memberUser = User::factory()->create();
        $member = Member::factory()->create(['user_id' => $memberUser->id, 'branch_id' => $branch->id]);
        $subscription = Subscription::factory()->create([
            'member_id' => $member->id,
            'membership_plan_id' => $plan->id,
            'status' => 'active',
        ]);

        $response = $this->get(route('admin.subscriptions.index'));
        $response->assertOk();
        $response->assertSee($subscription->id);

        $response = $this->get(route('admin.subscriptions.index', ['status' => 'active']));
        $response->assertOk();
        $response->assertSee($subscription->id);
    }

    #[Test]
    public function admin_can_renew_and_cancel_subscription()
    {
        $branch = Branch::factory()->create();
        $plan = \App\Models\MembershipPlan::factory()->create(['branch_id' => $branch->id]);
        $memberUser = User::factory()->create();
        $member = Member::factory()->create(['user_id' => $memberUser->id, 'branch_id' => $branch->id]);
        $subscription = Subscription::factory()->create([
            'member_id' => $member->id,
            'membership_plan_id' => $plan->id,
            'status' => 'active',
        ]);

        // Renew
        $response = $this->patch(route('admin.subscriptions.renew', $subscription));
        $response->assertRedirect();

        // Original subscription should be expired
        $subscription->refresh();
        $this->assertEquals('expired', $subscription->status);

        // Fetch the newly created active subscription
        $newSubscription = $subscription->member->subscriptions()->latest('id')->first();
        $this->assertNotEquals($subscription->id, $newSubscription->id);
        $this->assertEquals('active', $newSubscription->status);
        $this->assertTrue($newSubscription->end_date->gt(now()));

        // Cancel the new active subscription
        $response = $this->patch(route('admin.subscriptions.cancel', $newSubscription));
        $response->assertRedirect();
        $newSubscription->refresh();
        $this->assertEquals('cancelled', $newSubscription->status);
    }
}
