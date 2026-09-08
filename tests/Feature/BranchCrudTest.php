<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BranchCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_branches_list(): void
    {
        $branch = Branch::factory()->create(['name' => 'Main Branch']);

        $response = $this->actingAs($this->admin)->get(route('admin.branches.index'));
        $response->assertOk();
        $response->assertSee('Main Branch');
    }

    public function test_admin_can_create_branch(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->post(route('admin.branches.store'), [
            'name' => 'New Branch',
            'city' => 'Cairo',
            'address' => '123 Test St',
            'phone' => '01012345678',
            'map_link' => 'https://maps.google.com/?q=Cairo',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.branches.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('branches', [
            'name' => 'New Branch',
            'city' => 'Cairo',
        ]);
    }

    public function test_admin_can_update_branch(): void
    {
        $branch = Branch::factory()->create([
            'name' => 'Old Name',
            'city' => 'Old City',
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.branches.update', $branch), [
            'name' => 'Updated Name',
            'city' => 'Updated City',
            'address' => 'Updated Address',
            'phone' => '01099999999',
            'map_link' => 'https://maps.google.com/?q=Updated',
            'is_active' => '1',
        ]);
        $response->assertRedirect(route('admin.branches.index'));
        $this->assertDatabaseHas('branches', [
            'id' => $branch->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_branch_creation_fails_without_protocol_in_url(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.branches.store'), [
            'name' => 'Test Branch',
            'city' => 'Cairo',
            'address' => '123 Test St',
            'phone' => '01012345678',
            'map_link' => 'maps.google.com/test',
            'is_active' => '1',
        ]);

        $response->assertSessionHasErrors(['map_link']);
    }

    public function test_branch_creation_with_empty_map_link_succeeds(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.branches.store'), [
            'name' => 'Branch Without Map',
            'city' => 'Cairo',
            'address' => '123 Test St',
            'phone' => '01012345678',
            'map_link' => '',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.branches.index'));
        $this->assertDatabaseHas('branches', ['name' => 'Branch Without Map']);
    }
}
