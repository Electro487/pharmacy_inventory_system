<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Resources\PurchaseResource;
use App\Models\Purchase;
use App\Services\PurchaseService;
use Illuminate\Http\JsonResponse;

class PurchaseController extends Controller
{
    protected PurchaseService $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    public function index(): JsonResponse
    {
        $purchases = $this->purchaseService->getAll();

        return response()->json([
            'message' => 'Purchases retrieved successfully.',
            'purchases' => PurchaseResource::collection($purchases),
        ]);
    }

    public function show(Purchase $purchase): JsonResponse
    {
        $purchase->load(['supplier', 'items.medicine']);

        return response()->json([
            'message' => 'Purchase retrieved successfully.',
            'purchase' => new PurchaseResource($purchase),
        ]);
    }

    public function store(StorePurchaseRequest $request): JsonResponse
    {
        try {
            $purchase = $this->purchaseService->create(
                $request->validated()
            );

            return response()->json([
                'message' => 'Purchase created successfully.',
                'purchase' => new PurchaseResource($purchase),
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}