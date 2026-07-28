<?php

namespace App\Services;

use App\Models\Medicine;

class MedicineService
{
    public function getAll()
    {
        return Medicine::with(['category', 'unit'])
            ->latest()
            ->paginate(10);
    }

    public function create(array $data): Medicine
    {
        $data['selling_price'] = 0;
        $data['stock'] = 0;

        return Medicine::create($data);
    }

    public function update(Medicine $medicine, array $data): Medicine
    {
        $medicine->update($data);

        return $medicine;
    }

    public function delete(Medicine $medicine): void
    {
        $medicine->delete();
    }
}