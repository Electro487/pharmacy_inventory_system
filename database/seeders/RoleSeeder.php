<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'description' => 'Administrator role with full access',
                'status' => true,
            ],
            [
                'name' => 'Pharmacist',
                'description' => 'Pharmacist role with access to manage medications and prescriptions',
                'status' => true,
            ],
            [
                'name' => 'Cashier',
                'description' => 'Cashier role with access to process sales and handle transactions',
                'status' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
