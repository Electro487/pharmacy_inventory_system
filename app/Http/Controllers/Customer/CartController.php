<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Http\Requests\CartAddRequest;
use App\Http\Requests\CartUpdateRequest;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $customer = auth('customer')->user();
        $cart = $this->cartService->getCart($customer);

        return view('customer-cart.index', compact('cart'));
    }

    public function add(CartAddRequest $request)
    {
        $customer = auth('customer')->user();

        try {
            $this->cartService->addItem($customer, $request->medicine_id, $request->quantity);
            return redirect()->route('customer.medicines')->with('success', 'Medicine added to cart.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(CartUpdateRequest $request, int $cartItemId)
    {
        $customer = auth('customer')->user();

        try {
            $this->cartService->updateQuantity($customer, $cartItemId, $request->quantity);
            return redirect()->route('customer.cart')->with('success', 'Cart updated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function remove(int $cartItemId)
    {
        $customer = auth('customer')->user();

        try {
            $this->cartService->removeItem($customer, $cartItemId);
            return redirect()->route('customer.cart')->with('success', 'Item removed from cart.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function clear()
    {
        try {
            $customer = auth('customer')->user();
            $this->cartService->clearCart($customer);
            return redirect()->route('customer.cart')->with('success', 'Cart cleared.');
        } catch (\Exception $e) {
            return redirect()->route('customer.cart')->with('error', $e->getMessage());
        }
    }

    public function checkout()
    {
        $customer = auth('customer')->user();

        try {
            $order = $this->cartService->checkout($customer);
            return redirect()->route('customer.orders.show', $order)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            return redirect()->route('customer.cart')->with('error', $e->getMessage());
        }
    }
}