<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Sale;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\SaleService;
use Exception;

class OrderService
{
    protected SaleService $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function getCustomerOrders(Customer $customer)
    {
        return Order::where('customer_id', $customer->id)
            ->latest()
            ->paginate(10);
    }

    public function getAll()
    {
        return Order::with(['customer', 'items.medicine'])
            ->latest()
            ->paginate(10);
    }

    public function getById(int $id): Order
    {
        return Order::with([
            'items.medicine',
            'customer',
            'approver'
        ])->findOrFail($id);
    }

    public function approve(Order $order): Order
    {
        return DB::transaction(function () use ($order) {
            // Prevent approving non-pending orders
            if ($order->status !== OrderStatus::Pending) {
                throw new Exception('Only pending orders can be approved.');
            }

            // Extra safeguard: prevent duplicate sale creation
            if ($order->sale_id) {
                throw new Exception('Sale already exists for this order.');
            }

            // Reload with items and medicine
            $order->load('items.medicine');

            // Guard against empty orders
            if ($order->items->isEmpty()) {
                throw new Exception('Cannot approve an order with no items.');
            }

            // Check available stock again, excluding THIS order's reservation
            foreach ($order->items as $item) {
                $medicine = $item->medicine;
                $reserved = DB::table('order_items')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('order_items.medicine_id', $medicine->id)
                    ->where('orders.status', OrderStatus::Pending)
                    ->where('orders.id', '!=', $order->id)
                    ->sum('order_items.quantity');

                $available = max(0, $medicine->stock - $reserved);
                if ($available < $item->quantity) {
                    throw new Exception("Insufficient stock for {$medicine->name}. Available: {$available}, Required: {$item->quantity}");
                }
            }

            // Delegate to SaleService and get the created sale
            $sale = $this->saleService->createFromOrder($order);

            // Update Order with sale_id
            $order->update([
                'status' => OrderStatus::Approved,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'sale_id' => $sale->id,
            ]);

            return $order->fresh();
        });
    }

    public function reject(Order $order): Order
    {
        return DB::transaction(function () use ($order) {
            if ($order->status !== OrderStatus::Pending) {
                throw new Exception('Only pending orders can be rejected.');
            }

            $order->update([
                'status' => OrderStatus::Rejected,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            return $order->fresh();
        });
    }

    public function complete(Order $order): Order
    {
        if ($order->status !== OrderStatus::Approved) {
            throw new Exception('Only approved orders can be marked as completed.');
        }

        $order->update([
            'status' => OrderStatus::Completed,
        ]);

        return $order->fresh();
    }
}