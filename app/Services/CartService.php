<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Medicine;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\DB;
use Exception;

class CartService
{
    public function getCart(Customer $customer): Cart
    {
        $cart = $customer->cart;

        if (!$cart) {
            $cart = $customer->cart()->create();
        }

        return $cart->load('items.medicine');
    }

    public function addItem(Customer $customer, int $medicineId, int $quantity = 1): CartItem
    {
        $medicine = Medicine::findOrFail($medicineId);

        if ($medicine->available_stock < $quantity) {
            throw new Exception("Insufficient stock for {$medicine->name}. Available: {$medicine->available_stock}, Required: {$quantity}");
        }

        return DB::transaction(function () use ($customer, $medicineId, $quantity) {
            $cart = $this->getCart($customer);

            $existingItem = $cart->items()->where('medicine_id', $medicineId)->first();

            if ($existingItem) {
                $newQuantity = $existingItem->quantity + $quantity;
                if ($existingItem->medicine->available_stock < $newQuantity) {
                    throw new Exception("Insufficient stock for {$existingItem->medicine->name}. Available: {$existingItem->medicine->available_stock}, Required: {$newQuantity}");
                }
                $existingItem->update(['quantity' => $newQuantity]);
                return $existingItem->fresh();
            }

            return CartItem::create([
                'cart_id' => $cart->id,
                'medicine_id' => $medicineId,
                'quantity' => $quantity,
            ]);
        });
    }

    public function updateQuantity(Customer $customer, int $cartItemId, int $quantity): CartItem
    {
        if ($quantity < 1) {
            throw new Exception('Quantity must be at least 1.');
        }

        return DB::transaction(function () use ($customer, $cartItemId, $quantity) {
            $cart = $this->getCart($customer);
            $item = $cart->items()->findOrFail($cartItemId);

            if ($item->medicine->available_stock < $quantity) {
                throw new Exception("Insufficient stock for {$item->medicine->name}. Available: {$item->medicine->available_stock}, Required: {$quantity}");
            }

            $item->update(['quantity' => $quantity]);
            return $item->fresh();
        });
    }

    public function removeItem(Customer $customer, int $cartItemId): void
    {
        $cart = $this->getCart($customer);
        $item = $cart->items()->findOrFail($cartItemId);
        $item->delete();
    }

    public function clearCart(Customer $customer): void
    {
        $cart = $this->getCart($customer);
        $cart->items()->delete();
    }

    public function checkout(Customer $customer): Order
    {
        return DB::transaction(function () use ($customer) {
            $cart = $this->getCart($customer);

            if ($cart->items->isEmpty()) {
                throw new Exception('Cart is empty. Cannot checkout.');
            }

            // Check available stock for all items
            foreach ($cart->items as $item) {
                if ($item->medicine->available_stock < $item->quantity) {
                    throw new Exception("Insufficient stock for {$item->medicine->name}. Available: {$item->medicine->available_stock}, Required: {$item->quantity}");
                }
            }

            // Generate order number
            $orderNo = $this->generateOrderNumber();

            // Calculate total using cart accessor
            $total = $cart->total;

            // Create Order
            $order = Order::create([
                'customer_id' => $customer->id,
                'order_no' => $orderNo,
                'order_date' => now()->toDateString(),
                'total_amount' => $total,
                'status' => OrderStatus::Pending,
                'remarks' => null,
            ]);

            // Create OrderItems from CartItems
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'medicine_id' => $item->medicine_id,
                    'quantity' => $item->quantity,
                    'selling_price' => $item->medicine->selling_price,
                    'subtotal' => $item->medicine->selling_price * $item->quantity,
                ]);
            }

            // Clear cart
            $cart->items()->delete();

            return $order;
        });
    }

    private function generateOrderNumber(): string
    {
        $lastOrder = Order::latest('id')->first();

        if (!$lastOrder) {
            return 'ORD-000001';
        }

        $number = (int) str_replace('ORD-', '', $lastOrder->order_no);
        $number++;

        return 'ORD-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}