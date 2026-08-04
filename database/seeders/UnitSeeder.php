<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        Unit::create(
            ['name' => 'Tablet',  'description' => 'Tablet',  'status' => true],
            ['name' => 'Capsule', 'description' => 'Capsule', 'status' => true],
            ['name' => 'Bottle',  'description' => 'Bottle',  'status' => true],
            ['name' => 'Syrup',   'description' => 'Liquid Syrup', 'status' => true],
            ['name' => 'Tube',    'description' => 'Tube', 'status' => true],
            ['name' => 'Vial',    'description' => 'Vial', 'status' => true],
            ['name' => 'Ampoule', 'description' => 'Ampoule', 'status' => true],
            ['name' => 'Packet',  'description' => 'Packet', 'status' => true],
            ['name' => 'Box',     'description' => 'Box', 'status' => true],
        );
    }
}