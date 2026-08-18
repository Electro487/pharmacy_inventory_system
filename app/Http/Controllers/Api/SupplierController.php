<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Services\SupplierService;
use App\Models\Supplier;
use App\Http\Resources\SupplierResource;
use Illuminate\Http\JsonResponse;

class SupplierController extends Controller
{
    protected SupplierService $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    public function index(): JsonResponse
    {
        $suppliers = $this->supplierService->getAll();

        return response()->json([
            'suppliers' => SupplierResource::collection($suppliers),
        ]);
    }

    public function show(Supplier $supplier): JsonResponse
    {
        return response()->json([
            'supplier' => new SupplierResource($supplier),
        ]);
    }

    public function store(StoreSupplierRequest $request): JsonResponse
    {
        $supplier = $this->supplierService->create($request->validated());

        return response()->json([
            'message' => 'Supplier created successfully.',
            'supplier' => new SupplierResource($supplier),
        ], 201);
    }

    public function update(
        UpdateSupplierRequest $request,
        Supplier $supplier
    ): JsonResponse {
        $supplier = $this->supplierService->update(
            $supplier,
            $request->validated()
        );

        return response()->json([
            'message' => 'Supplier updated successfully.',
            'supplier' => new SupplierResource($supplier),
        ]);
    }

    public function destroy(Supplier $supplier): JsonResponse
    {
        try {
            $this->supplierService->delete($supplier);

            return response()->json([
                'message' => 'Supplier deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
