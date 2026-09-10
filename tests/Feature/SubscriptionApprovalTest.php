<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Member;
use App\Models\MembershipPlan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_subscription_starts_as_pending_without_updating_member_branch(): void
    {
        $branchA = Branch::factory()->create(['name' => 'Original Branch']);
        $branchB = Branch::factory()->create(['name' => 'Target Branch']);

        $planB = MembershipPlan::factory()->create([
            'branch_id' => $branchB->id,
            'duration' => '3_months',
            'price' => 199.99,
        ]);

        $user = User::factory()->create(['role' => 'member']);
        $member = $user->member;
        $member->update(['branch_id' => $branchA->id]);

        $response = $this->actingAs($user)->post(route('memberships.subscribe', $planB->id));

        $response->assertRedirect(route('member.memberships'));
        $response->assertSessionHas('success');

        // Subscription must be created with status 'pending'
        $this->assertDatabaseHas('subscriptions', [
            'member_id' => $member->id,
            'membership_plan_id' => $planB->id,
            'status' => 'pending',
            'amount_paid' => 199.99,
        ]);

        // Member's branch must NOT be changed to Branch B yet
        $member->refresh();
        $this->assertEquals($branchA->id, $member->branch_id);
    }

    public function test_admin_sees_client_details_and_pending_subscription(): void
    {
        $branch = Branch::factory()->create(['name' => 'Nasr City Arena']);
        $plan = MembershipPlan::factory()->create([
            'branch_id' => $branch->id,
            'duration' => '6_months',
        ]);

        $clientUser = User::factory()->create([
            'name' => 'Ahmed Client',
            'email' => 'ahmed.client@example.com',
            'role' => 'member',
        ]);
        $member = $clientUser->member;

        $subscription = Subscription::create([
            'member_id' => $member->id,
            'membership_plan_id' => $plan->id,
            'start_date' => Carbon::today()->toDateString(),
            'status' => 'pending',
            'amount_paid' => $plan->price,
        ]);

        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.subscriptions.index'));

        $response->assertOk();
        $response->assertSee('Ahmed Client');
        $response->assertSee('ahmed.client@example.com');
        $response->assertSee('Nasr City Arena');
        $response->assertSee('6 months');
        $response->assertSee('Pending');
        $response->assertSee('Approve');
        $response->assertSee('Reject');
    }

    public function test_admin_approval_activates_subscription_and_assigns_branch_to_client(): void
    {
        $branch = Branch::factory()->create(['name' => 'Heliopolis Flagship']);
        $plan = MembershipPlan::factory()->create([
            'branch_id' => $branch->id,
            'duration' => '3_months',
        ]);

        $clientUser = User::factory()->create(['name' => 'Sarah Athlete', 'role' => 'member']);
        $member = $clientUser->member;

        $subscription = Subscription::create([
            'member_id' => $member->id,
            'membership_plan_id' => $plan->id,
            'start_date' => Carbon::today()->subDays(2)->toDateString(),
            'status' => 'pending',
            'amount_paid' => $plan->price,
        ]);

        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->patch(route('admin.subscriptions.approve', $subscription));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // 1. Subscription becomes Active
        $subscription->refresh();
        $this->assertEquals('active', $subscription->status);
        $this->assertEquals(Carbon::today()->toDateString(), $subscription->start_date->toDateString());
        $this->assertEquals(Carbon::today()->addMonths(3)->toDateString(), $subscription->end_date->toDateString());

        // 2. Member branch is automatically updated to the subscription's branch
        $member->refresh();
        $this->assertEquals($branch->id, $member->branch_id);

        // 3. Subscription plan remains attached
        $this->assertEquals($plan->id, $subscription->membership_plan_id);
    }

    public function test_admin_rejection_marks_subscription_rejected(): void
    {
        $branch = Branch::factory()->create();
        $plan = MembershipPlan::factory()->create(['branch_id' => $branch->id]);

        $clientUser = User::factory()->create(['role' => 'member']);
        $member = $clientUser->member;

        $subscription = Subscription::create([
            'member_id' => $member->id,
            'membership_plan_id' => $plan->id,
            'start_date' => Carbon::today()->toDateString(),
            'status' => 'pending',
            'amount_paid' => $plan->price,
        ]);

        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->patch(route('admin.subscriptions.reject', $subscription));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $subscription->refresh();
        $this->assertEquals('rejected', $subscription->status);

        // Member branch was not assigned
        $member->refresh();
        $this->assertNull($member->branch_id);
    }
}
