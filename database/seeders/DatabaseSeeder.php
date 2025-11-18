<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

		$manager = User::factory()->create([
			'name' => 'Test Manager',
			'email' => 'manager.test@google.com',
			'password' => bcrypt('1234'),
		]);
		$manager->assignRole('manager');

		$admin = User::factory()->create([
			'name' => 'Test Admin',
			'email' => 'admin.test@google.com',
			'password' => bcrypt('1111'),
		]);
		$admin->assignRole ('admin');

		Customer::factory(20)->create();

		Ticket::factory(40)->create();

		$this->command->info('Seeding completed!');
		$this->command->info('Manager: manager.test@google.com / 1234');
		$this->command->info('Admin: admin.test@google.com / 1111');

    }
}
