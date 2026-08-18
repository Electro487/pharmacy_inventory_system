<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Services\UnitService;
use App\Models\Unit;
use App\Http\Resources\UnitResource;
use Illuminate\Http\JsonResponse;

class UnitController extends Controller
{
    protected UnitService $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function index(): JsonResponse
    {
        $units = $this->unitService->getAll();

        return response()->json([
            'units' => UnitResource::collection($units),
        ]);
    }

    public function show(Unit $unit): JsonResponse
    {
        return response()->json([
            'unit' => new UnitResource($unit),
        ]);
    }

    public function store(StoreUnitRequest $request): JsonResponse
    {
        $unit = $this->unitService->create($request->validated());

        return response()->json([
            'message' => 'Unit created successfully.',
            'unit' => new UnitResource($unit),
        ], 201);
    }

    public function update(
        UpdateUnitRequest $request,
        Unit $unit
    ): JsonResponse {
        $unit = $this->unitService->update(
            $unit,
            $request->validated()
        );

        return response()->json([
            'message' => 'Unit updated successfully.',
            'unit' => new UnitResource($unit),
        ]);
    }

    public function destroy(Unit $unit): JsonResponse
    {
        try {
            $this->unitService->delete($unit);

            return response()->json([
                'message' => 'Unit deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
