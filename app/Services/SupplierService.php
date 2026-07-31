<?php

namespace App\Services;

use App\Models\Supplier;

class SupplierService
{
    public function getAll()
    {
        return Supplier::latest()->paginate(10);//customPagination 
    }

    public function create(array $data): Supplier
    {
        return Supplier::create($data);
    }

    public function update(Supplier $supplier, array $data): Supplier
    {
        $supplier->update($data);
        return $supplier;
    }

    public function delete(Supplier $supplier): void
    {
        $supplier->delete();
    }
}
