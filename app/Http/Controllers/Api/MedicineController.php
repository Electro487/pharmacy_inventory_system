<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Http\Requests\StoreMedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;

class MedicineController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Medicines retrieved successfully.',
            'medicines' => Medicine::with(['category', 'unit'])->get(),
        ]);
    }

    public function show(Medicine $medicine)
    {
        return response()->json([
            'message' => 'Medicine retrieved successfully.',
            'medicine' => $medicine->load(['category', 'unit']),
        ]);
    }

    public function store(StoreMedicineRequest $request)
    {
        $medicine = Medicine::create($request->validated());

        return response()->json([
            'message' => 'Medicine created successfully.',
            'medicine' => $medicine->load(['category', 'unit']),
        ], 201);
    }

    public function update(UpdateMedicineRequest $request, Medicine $medicine) 
    {
        $medicine->update($request->validated());

        return response()->json([
            'message' => 'Medicine updated successfully.',
            'medicine' => $medicine->fresh()->load(['category', 'unit']),
        ]);
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return response()->json([
            'message' => 'Medicine deleted successfully.'
        ]);
    }
}