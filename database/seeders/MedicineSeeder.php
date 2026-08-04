<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Medicine;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        if (Medicine::where('name', 'Paracetamol 500 mg')->exists()) {
            return;
        }

        $categories = [
            'Pain Relief' => 'Pain relief medications',
            'Antibiotics' => 'Antibiotic medications',
        ];

        $units = [
            'Tablet', 'Capsule', 'Syrup', 'Suspension',
            'Ampoule', 'Vial', 'Tube', 'Gel',
        ];

        $categoryMap = [];
        foreach ($categories as $name => $desc) {
            $cat = Category::firstOrCreate(
                ['name' => $name],
                ['description' => $desc, 'status' => true]
            );
            $categoryMap[$name] = $cat->id;
        }

        $unitMap = [];
        foreach ($units as $name) {
            $unit = Unit::firstOrCreate(
                ['name' => $name],
                ['status' => true]
            );
            $unitMap[$name] = $unit->id;
        }

        $medicines = [
            [
                'category' => 'Antibiotics',
                'unit' => 'Vial',
                'name' => 'Ceftriaxone 1 g',
                'generic_name' => 'Ceftriaxone',
                'brand' => 'Rocephin',
                'reorder_level' => 10,
                'description' => 'Injectable antibiotic',
            ],
            [
                'category' => 'Pain Relief',
                'unit' => 'Tablet',
                'name' => 'Paracetamol 500 mg',
                'generic_name' => 'Paracetamol',
                'brand' => 'Panadol',
                'reorder_level' => 20,
                'description' => 'Relieves pain and fever',
            ],
            [
                'category' => 'Pain Relief',
                'unit' => 'Tablet',
                'name' => 'Ibuprofen 400 mg',
                'generic_name' => 'Ibuprofen',
                'brand' => 'Brufen',
                'reorder_level' => 15,
                'description' => 'Anti-inflammatory pain reliever',
            ],
            [
                'category' => 'Pain Relief',
                'unit' => 'Tablet',
                'name' => 'Diclofenac 50 mg',
                'generic_name' => 'Diclofenac Sodium',
                'brand' => 'Voltaren',
                'reorder_level' => 10,
                'description' => 'Pain and inflammation relief',
            ],
            [
                'category' => 'Pain Relief',
                'unit' => 'Ampoule',
                'name' => 'Diclofenac Injection 75 mg',
                'generic_name' => 'Diclofenac Sodium',
                'brand' => 'Voveran',
                'reorder_level' => 10,
                'description' => 'Injectable pain reliever',
            ],
            [
                'category' => 'Pain Relief',
                'unit' => 'Syrup',
                'name' => 'Paracetamol Syrup 120 mg/5 ml',
                'generic_name' => 'Paracetamol',
                'brand' => 'Calpol',
                'reorder_level' => 10,
                'description' => 'Pediatric fever and pain relief',
            ],
            [
                'category' => 'Pain Relief',
                'unit' => 'Tube',
                'name' => 'Diclofenac Gel',
                'generic_name' => 'Diclofenac Diethylamine',
                'brand' => 'Voltaren Gel',
                'reorder_level' => 10,
                'description' => 'Topical pain relief gel',
            ],
            [
                'category' => 'Antibiotics',
                'unit' => 'Syrup',
                'name' => 'Amoxicillin Suspension',
                'generic_name' => 'Amoxicillin',
                'brand' => 'Mox Syrup',
                'reorder_level' => 10,
                'description' => 'Pediatric antibiotic suspension',
            ],
            [
                'category' => 'Antibiotics',
                'unit' => 'Tablet',
                'name' => 'Metronidazole 400 mg',
                'generic_name' => 'Metronidazole',
                'brand' => 'Flagyl',
                'reorder_level' => 10,
                'description' => 'Treats anaerobic bacterial infections',
            ],
            [
                'category' => 'Pain Relief',
                'unit' => 'Tablet',
                'name' => 'Aspirin 75 mg',
                'generic_name' => 'Aspirin',
                'brand' => 'Disprin',
                'reorder_level' => 10,
                'description' => 'Low-dose pain relief and antiplatelet',
            ],
            [
                'category' => 'Pain Relief',
                'unit' => 'Capsule',
                'name' => 'Tramadol 50 mg',
                'generic_name' => 'Tramadol',
                'brand' => 'Tramal',
                'reorder_level' => 10,
                'description' => 'Moderate to severe pain management',
            ],
        ];

        foreach ($medicines as $med) {
            Medicine::create([
                'category_id' => $categoryMap[$med['category']],
                'unit_id' => $unitMap[$med['unit']],
                'name' => $med['name'],
                'generic_name' => $med['generic_name'],
                'brand' => $med['brand'],
                'selling_price' => 0,
                'stock' => 0,
                'reorder_level' => $med['reorder_level'],
                'description' => $med['description'],
                'status' => true,
            ]);
        }
    }
}
