<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Pain Relief',
            'description' => 'Medications for pain relief',
            'status' => true,
        ]);

        Category::create([
            'name' => 'Antibiotics',
            'description' => 'Antibiotic medications',
            'status' => true,
        ]);
    }
}