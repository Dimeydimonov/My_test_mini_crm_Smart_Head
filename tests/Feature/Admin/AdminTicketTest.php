<?php

	namespace Tests\Feature\Admin;

	use App\Models\User;
	use App\Models\Ticket;
	use Illuminate\Foundation\Testing\RefreshDatabase;
	use Spatie\Permission\Models\Role;
	use Tests\TestCase;

	class AdminTicketTest extends TestCase
	{
		use RefreshDatabase;

		protected function setUp(): void
		{
			parent::setUp();

			// Создать роли
			Role::create(['name' => 'admin']);
			Role::create(['name' => 'manager']);
		}

		public function test_manager_can_view_tickets(): void
		{
			$manager = User::factory()->create();
			$manager->assignRole('manager');

			Ticket::factory()->count(3)->create();

			$response = $this->actingAs($manager)
				->get('/admin/tickets');

			$response->assertStatus(200)
				->assertViewIs('admin.tickets.index')
				->assertViewHas('tickets');
		}

		public function test_manager_can_change_status(): void
		{
			$manager = User::factory()->create();
			$manager->assignRole('manager');

			$ticket = Ticket::factory()->create(['status' => 'new']);

			$response = $this->actingAs($manager)
				->patch("/admin/tickets/{$ticket->id}/status", [
					'status' => 'in_progress'
				]);

			$response->assertRedirect();

			$this->assertDatabaseHas('tickets', [
				'id' => $ticket->id,
				'status' => 'in_progress',
			]);
		}

		public function test_guest_cannot_access_admin(): void
		{
			$response = $this->get('/admin/dashboard');

			$response->assertRedirect('/login');
		}
	}