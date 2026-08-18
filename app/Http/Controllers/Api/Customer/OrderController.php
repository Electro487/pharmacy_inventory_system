<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request): JsonResponse
    {
        $customer = $request->user();

        $orders = Order::with('items.medicine')
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        return response()->json([
            'orders' => OrderResource::collection($orders),
        ]);
    }

    public function show(Request $request, Order $order): JsonResponse
    {
        $customer = $request->user();

        if ($order->customer_id !== $customer->id) {
            return response()->json([
                'message' => 'Order not found.'
            ], 404);
        }

        return response()->json([
            'order' => new OrderResource(
                $order->load('items.medicine')
            ),
        ]);
    }

    public function checkout(Request $request): JsonResponse
    {
        $customer = $request->user();

        try {
            $order = $this->cartService->checkout($customer);

            return response()->json([
                'message' => 'Order placed successfully.',
                'order' => new OrderResource(
                    $order->load('items.medicine')
                ),
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}