<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\MembershipPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicBranchTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_limits_branches_to_three_using_query(): void
    {
        // Create 6 active branches
        $activeBranches = Branch::factory()->count(6)->create([
            'is_active' => true,
        ]);

        // Create 2 inactive branches
        Branch::factory()->count(2)->create([
            'is_active' => false,
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewHas('featuredBranches', function ($featuredBranches) {
            return $featuredBranches->count() === 3;
        });

        // Ensure "Show All Branches" button is present and links to route('branches.index')
        $response->assertSee(route('branches.index'));
    }

    public function test_public_branches_page_displays_all_active_branches(): void
    {
        // Create 5 active branches
        $activeBranches = Branch::factory()->count(5)->create([
            'is_active' => true,
        ]);

        // Create 2 inactive branches
        $inactiveBranches = Branch::factory()->count(2)->create([
            'is_active' => false,
            'name' => 'Inactive Secret Branch',
        ]);

        $response = $this->get(route('branches.index'));

        $response->assertOk();
        $response->assertViewIs('pages.branches');
        $response->assertViewHas('branches', function ($branches) {
            return $branches->count() === 5;
        });

        // Ensure active branches are displayed
        foreach ($activeBranches as $branch) {
            $response->assertSee($branch->name);
        }

        // Ensure inactive branches are NOT displayed
        $response->assertDontSee('Inactive Secret Branch');
    }

    public function test_public_branches_page_preserves_view_plans_and_details(): void
    {
        $branch = Branch::factory()->create([
            'name' => 'Cairo Arena',
            'city' => 'Cairo',
            'address' => '10 Tahrir Square',
            'is_active' => true,
        ]);

        MembershipPlan::factory()->create([
            'branch_id' => $branch->id,
            'duration' => '1_month',
            'price' => 149.99,
            'is_active' => true,
        ]);

        $response = $this->get(route('branches.index'));

        $response->assertOk();
        $response->assertSee('Cairo Arena');
        $response->assertSee('Cairo');
        $response->assertSee('10 Tahrir Square');
        $response->assertSee('$149.99');
        $response->assertSee(route('memberships.index'));
    }
}
