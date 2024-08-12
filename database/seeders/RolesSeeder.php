<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $employeeRole = Role::create(['name' => 'employee']);
        $managerRole = Role::create(['name' => 'manager']);

        // Assign roles to users (assuming you have some users)
        $adminUser = User::where('email', 'admin@example.com')->first();
        if ($adminUser) {
            $adminUser->roles()->attach($adminRole);
        }

        $employeeUser = User::where('email', 'employee@example.com')->first();
        if ($employeeUser) {
            $employeeUser->roles()->attach($employeeRole);
        }

        $managerUser = User::where('email', 'manager@example.com')->first();
        if ($managerUser) {
            $managerUser->roles()->attach($managerRole);
        }
    }
}