<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SaleResource;
use App\Models\Sale;
use App\Services\SaleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    protected SaleService $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index(): JsonResponse
    {
        $sales = $this->saleService->getAll(Auth::user());

        return response()->json([
            'message' => 'Sales retrieved successfully.',
            'sales' => SaleResource::collection($sales),
        ]);
    }

    public function show(Sale $sale): JsonResponse
    {
        $sale = $this->saleService->getById($sale->id);

        if (Auth::user()->isCashier() && $sale->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'You are not authorized to view this sale.',
            ], 403);
        }

        return response()->json([
            'message' => 'Sale retrieved successfully.',
            'sale' => new SaleResource($sale),
        ]);
    }
}