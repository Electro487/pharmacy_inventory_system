<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'role_id'  => 1,
            'name'     => 'Admin',
            'email'    => 'admin@pharmacy.com',
            'password' => Hash::make('pharmacy123'),
            'status'   => true,
        ],

        [
            'role_id'  => 2,
            'name'     => 'Pharmacist',
            'email'    => 'pharmacist@pharmacy.com',
            'password' => Hash::make('pharmacy123'),
            'status'   => true,
        ],

       [
            'role_id'  => 3,
            'name'     => 'Cashier',
            'email'    => 'cashier@pharmacy.com',
            'password' => Hash::make('pharmacy123'),
            'status'   => true,
        ]);
    }
}