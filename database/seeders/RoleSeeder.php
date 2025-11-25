<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $manager = Role::create(['name' => 'manager']);

        $viewTickets = Role::create(['name' => 'view tickets']);
        $editTickets = Role::create(['name' => 'edit tickets']);
        $viewStats = Role::create(['name' => 'view statistics']);

        $admin->givePermissionTo([$viewTickets, $editTickets, $viewStats]);
        $manager->givePermissionTo([$viewTickets, $editTickets, $viewStats]);
    }
}
