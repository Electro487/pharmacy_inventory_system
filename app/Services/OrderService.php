<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Sale;
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
            if ($order->status !== 'pending') {
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

            // Check stock again
            foreach ($order->items as $item) {
                $medicine = $item->medicine;
                if ($medicine->stock < $item->quantity) {
                    throw new Exception("Insufficient stock for {$medicine->name}. Available: {$medicine->stock}, Required: {$item->quantity}");
                }
            }

            // Delegate to SaleService and get the created sale
            $sale = $this->saleService->createFromOrder($order);

            // Update Order with sale_id
            $order->update([
                'status' => 'approved',
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
            if ($order->status !== 'pending') {
                throw new Exception('Only pending orders can be rejected.');
            }

            $order->update([
                'status' => 'rejected',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            return $order->fresh();
        });
    }
}