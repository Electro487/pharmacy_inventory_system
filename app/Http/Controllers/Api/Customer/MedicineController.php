<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Http\Resources\CustomerMedicineResource;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::with(['category', 'unit'])
            ->where('status', true)
            ->get();

        return CustomerMedicineResource::collection($medicines);
    }

    public function show(Medicine $medicine)
    {
        if (!$medicine->status || $medicine->stock <= 0) {
            return response()->json([
                'message' => 'Medicine not available.'
            ], 404);
        }

        return new CustomerMedicineResource(
            $medicine->load(['category', 'unit'])
        );
    }
}