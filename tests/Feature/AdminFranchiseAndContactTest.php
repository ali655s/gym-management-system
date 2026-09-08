<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\FranchiseApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminFranchiseAndContactTest extends TestCase
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
    public function non_admin_cannot_access_franchise_applications_routes()
    {
        $member = User::factory()->create(['role' => 'member']);
        $this->actingAs($member);

        $response = $this->get(route('admin.franchise-applications.index'));
        $response->assertForbidden();
    }

    #[Test]
    public function non_admin_cannot_access_contact_messages_routes()
    {
        $member = User::factory()->create(['role' => 'member']);
        $this->actingAs($member);

        $response = $this->get(route('admin.contact-messages.index'));
        $response->assertForbidden();
    }

    #[Test]
    public function admin_can_view_search_and_filter_franchise_applications()
    {
        $app1 = FranchiseApplication::create([
            'full_name' => 'Tarek Mansour',
            'email' => 'tarek@example.com',
            'phone' => '01000000001',
            'city' => 'Alexandria',
            'capital' => '$250,000',
            'message' => 'Interested in franchise',
            'status' => 'pending',
        ]);

        $app2 = FranchiseApplication::create([
            'full_name' => 'Sara Gamal',
            'email' => 'sara@example.com',
            'phone' => '01000000002',
            'city' => 'Cairo',
            'capital' => '$500,000',
            'message' => 'Already running clubs',
            'status' => 'approved',
        ]);

        // View index
        $response = $this->get(route('admin.franchise-applications.index'));
        $response->assertOk();
        $response->assertSee('Tarek Mansour');
        $response->assertSee('Sara Gamal');

        // Filter by status
        $filterResponse = $this->get(route('admin.franchise-applications.index', ['status' => 'pending']));
        $filterResponse->assertOk();
        $filterResponse->assertSee('Tarek Mansour');
        $filterResponse->assertDontSee('Sara Gamal');

        // Search by name
        $searchResponse = $this->get(route('admin.franchise-applications.index', ['search' => 'Sara']));
        $searchResponse->assertOk();
        $searchResponse->assertSee('Sara Gamal');
        $searchResponse->assertDontSee('Tarek Mansour');
    }

    #[Test]
    public function admin_can_view_single_franchise_application()
    {
        $app = FranchiseApplication::create([
            'full_name' => 'Hassan Ali',
            'email' => 'hassan@example.com',
            'phone' => '01000000003',
            'city' => 'Giza',
            'capital' => '$300,000',
            'message' => 'Experienced investor looking for expansion.',
            'status' => 'pending',
        ]);

        $response = $this->get(route('admin.franchise-applications.show', $app));
        $response->assertOk();
        $response->assertSee('Hassan Ali');
        $response->assertSee('Experienced investor looking for expansion.');
    }

    #[Test]
    public function admin_can_update_franchise_application_status()
    {
        $app = FranchiseApplication::create([
            'full_name' => 'Ramy Youssef',
            'email' => 'ramy@example.com',
            'phone' => '01000000004',
            'city' => 'Mansoura',
            'capital' => '$200,000',
            'status' => 'pending',
        ]);

        // Approve
        $approveResponse = $this->patch(route('admin.franchise-applications.updateStatus', $app), [
            'status' => 'approved',
        ]);
        $approveResponse->assertRedirect();
        $this->assertDatabaseHas('franchise_applications', [
            'id' => $app->id,
            'status' => 'approved',
        ]);

        // Reject
        $rejectResponse = $this->patch(route('admin.franchise-applications.updateStatus', $app), [
            'status' => 'rejected',
        ]);
        $rejectResponse->assertRedirect();
        $this->assertDatabaseHas('franchise_applications', [
            'id' => $app->id,
            'status' => 'rejected',
        ]);
    }

    #[Test]
    public function admin_can_delete_franchise_application()
    {
        $app = FranchiseApplication::create([
            'full_name' => 'Mohamed Fathy',
            'email' => 'mohamed@example.com',
            'phone' => '01000000005',
            'city' => 'Aswan',
            'capital' => '$150,000',
            'status' => 'pending',
        ]);

        $response = $this->delete(route('admin.franchise-applications.destroy', $app));
        $response->assertRedirect(route('admin.franchise-applications.index'));
        $this->assertDatabaseMissing('franchise_applications', ['id' => $app->id]);
    }

    #[Test]
    public function admin_can_view_search_and_filter_contact_messages()
    {
        $msg1 = ContactMessage::create([
            'name' => 'Yasmine Adel',
            'email' => 'yasmine@example.com',
            'message' => 'Do you provide personal trainers?',
            'is_read' => false,
        ]);

        $msg2 = ContactMessage::create([
            'name' => 'Omar Farouk',
            'email' => 'omar@example.com',
            'message' => 'Inquiry about pool schedule',
            'is_read' => true,
        ]);

        // View index
        $response = $this->get(route('admin.contact-messages.index'));
        $response->assertOk();
        $response->assertSee('Yasmine Adel');
        $response->assertSee('Omar Farouk');

        // Filter unread
        $unreadResponse = $this->get(route('admin.contact-messages.index', ['status' => 'unread']));
        $unreadResponse->assertOk();
        $unreadResponse->assertSee('Yasmine Adel');
        $unreadResponse->assertDontSee('Omar Farouk');

        // Search
        $searchResponse = $this->get(route('admin.contact-messages.index', ['search' => 'pool']));
        $searchResponse->assertOk();
        $searchResponse->assertSee('Omar Farouk');
        $searchResponse->assertDontSee('Yasmine Adel');
    }

    #[Test]
    public function viewing_contact_message_automatically_marks_it_as_read()
    {
        $msg = ContactMessage::create([
            'name' => 'Amr Diab',
            'email' => 'amr@example.com',
            'message' => 'What are your working hours?',
            'is_read' => false,
        ]);

        $this->assertFalse($msg->is_read);

        $response = $this->get(route('admin.contact-messages.show', $msg));
        $response->assertOk();
        $response->assertSee('What are your working hours?');

        $this->assertTrue($msg->fresh()->is_read);
    }

    #[Test]
    public function admin_can_toggle_contact_message_read_state()
    {
        $msg = ContactMessage::create([
            'name' => 'Dina Samy',
            'email' => 'dina@example.com',
            'message' => 'Membership renewal question',
            'is_read' => true,
        ]);

        // Toggle to unread
        $response = $this->patch(route('admin.contact-messages.toggleRead', $msg));
        $response->assertRedirect();
        $this->assertFalse($msg->fresh()->is_read);

        // Toggle back to read
        $response = $this->patch(route('admin.contact-messages.toggleRead', $msg));
        $response->assertRedirect();
        $this->assertTrue($msg->fresh()->is_read);
    }

    #[Test]
    public function admin_can_delete_contact_message()
    {
        $msg = ContactMessage::create([
            'name' => 'Karim Nour',
            'email' => 'karim@example.com',
            'message' => 'Spam message',
            'is_read' => false,
        ]);

        $response = $this->delete(route('admin.contact-messages.destroy', $msg));
        $response->assertRedirect();
        $this->assertDatabaseMissing('contact_messages', ['id' => $msg->id]);
    }

    #[Test]
    public function login_page_displays_register_button()
    {
        auth()->logout();
        $response = $this->get(route('login'));
        $response->assertOk();
        $response->assertSee(route('register'));
        $response->assertSee('Create New Account');
    }

    #[Test]
    public function admin_sees_dashboard_button_on_public_navbar_while_member_does_not()
    {
        // As Admin
        $response = $this->actingAs($this->admin)->get(route('home'));
        $response->assertOk();
        $response->assertSee(route('admin.dashboard'));
        $response->assertSee('Admin Dashboard');

        // As Member
        $member = User::factory()->create(['role' => 'member']);
        $response = $this->actingAs($member)->get(route('home'));
        $response->assertOk();
        $response->assertDontSee(route('admin.dashboard'));
        $response->assertDontSee('Admin Dashboard');
    }
}
