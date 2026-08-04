<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Medicine;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::where('status', true)
            ->where('stock', '>', 0)
            ->with(['category', 'unit'])
            ->latest()
            ->paginate(12);

        return view('customer-medicines.index', compact('medicines'));
    }

    public function show(Medicine $medicine)
    {
        $medicine->load(['category', 'unit']);

        return view('customer-medicines.show', compact('medicine'));
    }
}