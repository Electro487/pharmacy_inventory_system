<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Http\Requests\CartAddRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Http\Requests\CartUpdateRequest;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request): JsonResponse
    {
        $customer = $request->user();
        $cart = $this->cartService->getCart($customer);

        return response()->json([
            'message' => 'Cart retrieved successfully.',
            'cart' => new CartResource($cart),
        ]);
    }

    public function add(CartAddRequest $request): JsonResponse
    {
        $customer = $request->user();

        try {
            $this->cartService->addItem($customer, $request->medicine_id, $request->quantity);

            return response()->json([
                'message' => 'Medicine added to cart.',
                'cart' => new CartResource(
                    $this->cartService->getCart($customer)
                ),
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function update(CartUpdateRequest $request, int $cartItemId): JsonResponse
    {
        $customer = $request->user();

        try {
            $this->cartService->updateQuantity($customer, $cartItemId, $request->quantity);

            return response()->json([
                'message' => 'Cart updated successfully.',
                'cart' => new CartResource(
                    $this->cartService->getCart($customer)
                ),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function remove(Request $request, int $cartItemId): JsonResponse
    {
        $customer = $request->user();

        try {
            $this->cartService->removeItem($customer, $cartItemId);

            return response()->json([
                'message' => 'Item removed from cart.',
                'cart' => new CartResource(
                    $this->cartService->getCart($customer)
                ),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function clear(Request $request): JsonResponse
    {
        $customer = $request->user();

        try {
            $this->cartService->clearCart($customer);

            return response()->json([
                'message' => 'Cart cleared successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}