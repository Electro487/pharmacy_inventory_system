<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\Unit;
use App\Services\MedicineService;

class MedicineController extends Controller
{
    protected MedicineService $medicineService;

    public function __construct(MedicineService $medicineService)
    {
        $this->medicineService = $medicineService;
    }

    public function index()
    {
        $medicines = $this->medicineService->getAll();

        return view('medicines.index', compact('medicines'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->orderBy('name')->get();
        $units = Unit::where('status', true)->orderBy('name')->get();

        return view('medicines.create', compact('categories', 'units'));
    }

    public function store(StoreMedicineRequest $request)
    {
        $this->medicineService->create($request->validated());

        return redirect()
            ->route('medicines.index')
            ->with('success', 'Medicine created successfully.');
    }

    public function edit(Medicine $medicine)
    {
        $categories = Category::where('status', true)->orderBy('name')->get();
        $units = Unit::where('status', true)->orderBy('name')->get();

        return view('medicines.edit', compact('medicine', 'categories', 'units'));
    }

    public function update(UpdateMedicineRequest $request, Medicine $medicine)
    {
        $this->medicineService->update($medicine, $request->validated());

        return redirect()
            ->route('medicines.index')
            ->with('success', 'Medicine updated successfully.');
    }

    public function destroy(Medicine $medicine)
    {
        $this->medicineService->delete($medicine);

        return redirect()
            ->route('medicines.index')
            ->with('success', 'Medicine deleted successfully.');
    }
}