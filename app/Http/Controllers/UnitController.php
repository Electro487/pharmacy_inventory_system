<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Services\UnitService;
use App\Models\Unit;

class UnitController extends Controller
{
    protected UnitService $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function create()
    {
        return view('units.create');
    }

    public function index()
    {
        $units = $this->unitService->getAll();
        return view('units.index', compact('units'));
    }

    public function store(StoreUnitRequest $request)
    {
        $data = $request->validated();
        $unit = $this->unitService->create($data);
        return redirect()->route('units.index')->with('success', 'Unit created successfully.');
    }

    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }

    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        $data = $request->validated();
        $this->unitService->update($unit, $data);
        return redirect()->route('units.index')->with('success', 'Unit updated successfully.');
    }

    public function destroy(Unit $unit)
    {
        $this->unitService->delete($unit);
        return redirect()->route('units.index')->with('success', 'Unit deleted successfully.');
    }
}
