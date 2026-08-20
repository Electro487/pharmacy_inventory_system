<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\OrderResource;
use App\Http\Resources\SaleResource;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(): JsonResponse
    {
        $orders = $this->orderService->getAll();

        return response()->json([
            'message' => 'Orders retrieved successfully.',
            'orders' => OrderResource::collection($orders),
        ]);
    }

    public function show(Order $order): JsonResponse
    {
        $order = $this->orderService->getById($order->id);

        return response()->json([
            'message' => 'Order retrieved successfully.',
            'order' => new OrderResource($order),
        ]);
    }

    public function approve(Order $order): JsonResponse
    {
        try {
            $order = $this->orderService->approve($order);

            return response()->json([
                'message' => 'Order approved successfully.',
                'order' => new OrderResource($order),
            ]);
        } catch (\Exception $e) {
            // \Log 
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function reject(Order $order): JsonResponse
    {
        try {
            $order = $this->orderService->reject($order);

            return response()->json([
                'message' => 'Order rejected.',
                'order' => new OrderResource($order),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function complete(Request $request, Order $order): JsonResponse
    {
        try {
            $data = $request->validate([
                'vat_rate' => ['nullable', 'numeric', 'in:0,13'],
            ], [
                'vat_rate.in' => 'VAT rate must be either 0 (no VAT) or 13 percent.',
            ]);

            $vatRate = $data['vat_rate'] ?? 0;
            $order = $this->orderService->complete($order, $vatRate);

            $sale = $order->load('sale')
                ->sale
                ->load('items.medicine');

            return response()->json([
                'message' => 'Order marked as completed.',
                'order' => new OrderResource($order),
                'sale' => new SaleResource($sale),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}