<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\OrderResource;

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
            'orders' => OrderResource::collection($orders),
        ]);
    }

    public function show(Order $order): JsonResponse
    {
        $order = $this->orderService->getById($order->id);

        return response()->json([
            'order' => new OrderResource($order),
        ]);
    }

    public function approve(Order $order): JsonResponse
    {
        try {
            $order = $this->orderService->approve($order);

            return response()->json([
                'message' => 'Order approved and sale created.',
                'order' => new OrderResource($order),
            ]);
        } catch (\Exception $e) {
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

    public function complete(Order $order): JsonResponse
    {
        try {
            $order = $this->orderService->complete($order);

            return response()->json([
                'message' => 'Order marked as completed.',
                'order' => new OrderResource($order),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}