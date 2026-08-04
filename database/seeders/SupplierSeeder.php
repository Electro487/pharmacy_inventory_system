<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::create(
            ['name' => 'MediSupply Co.', 'company' => 'MediSupply Corp', 'phone' => '1234567890', 'email' => 'info@medisupply.com', 'address' => '123 Supplier St', 'status' => true],
            ['name' => 'PharmaDistributors', 'company' => 'Pharma Distributors Inc', 'phone' => '9876543210', 'email' => 'contact@pharmadist.com', 'address' => '456 Distributor Ave', 'status' => true],
        );
    }
}