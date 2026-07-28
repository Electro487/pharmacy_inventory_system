<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        Medicine::create([
            'category_id' => 1,
            'unit_id' => 1,
            'name' => 'Paracetamol',
            'generic_name' => 'Acetaminophen',
            'brand' => 'Tylenol',
            'selling_price' => 5.00,
            'stock' => 100,
            'reorder_level' => 10,
            'description' => 'Common pain reliever',
            'status' => true,
        ]);

        Medicine::create([
            'category_id' => 2,
            'unit_id' => 2,
            'name' => 'Amoxicillin',
            'generic_name' => 'Amoxicillin',
            'brand' => 'Amoxil',
            'selling_price' => 15.00,
            'stock' => 50,
            'reorder_level' => 5,
            'description' => 'Antibiotic medication',
            'status' => true,
        ]);
    }
}