<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerSaleResource;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SaleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $customer = $request->user();

        $sales = Sale::with('items.medicine')
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Sales retrieved successfully.',
            'sales' => CustomerSaleResource::collection($sales),
        ]);
    }

    public function show(Request $request, Sale $sale): JsonResponse
    {
        $customer = $request->user();

        if ($sale->customer_id !== $customer->id) {
            return response()->json([
                'message' => 'Sale not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Sale retrieved successfully.',
            'sale' => new CustomerSaleResource(
                $sale->load('items.medicine')
            ),
        ]);
    }
}