<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{

    public function run(): void
    {
        $admin = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
		$manager = \Spatie\Permission\Models\Role::create(['name' => 'manager']);

		$viewTickets = \Spatie\Permission\Models\Role::create(['name' => 'view tickets']);
		$editTickets = \Spatie\Permission\Models\Role::create(['name' => 'edit tickets']);
		$viewStats = \Spatie\Permission\Models\Role::create(['name' => 'view statistics']);

		$admin->givePermissionTo([$viewTickets, $editTickets, $viewStats]);
		$manager->givePermissionTo([$viewTickets, $editTickets, $viewStats]);
    }
}
