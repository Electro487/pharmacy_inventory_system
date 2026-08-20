<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use App\Models\Order;
use App\Enums\PaymentStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Exception;

class SaleService
{
    public function getAll(User $user)
    {
        $query = Sale::with(['customer', 'user']);
        if ($user->isCashier()) {
            $query->where('user_id', $user->id);
        }
        return $query->latest()->paginate(10);
    }

    public function getById(int $id): Sale
    {
        return Sale::with(['customer', 'user', 'items.medicine'])
            ->findOrFail($id);
    }

    public function getCustomerSales(Customer $customer)
    {
        return Sale::where('customer_id', $customer->id)
            ->latest()
            ->paginate(10);
    }

    private function generateInvoiceNumber(): string
    {
        $lastSale = Sale::latest('id')->first();

        if (!$lastSale) {
            return 'SAL-000001';
        }

        $number = (int) str_replace('SAL-', '', $lastSale->invoice_no);
        $number++;

        return 'SAL-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }

    public function createFromOrder(Order $order, float $vatRate = 0): Sale
    {
        return DB::transaction(function () use ($order, $vatRate) {
            $order->load('items.medicine');

            if ($order->items->isEmpty()) {
                throw new Exception('Cannot create sale from empty order.');
            }

            $invoiceNo = $this->generateInvoiceNumber();

            $subtotal = round($order->items->sum('subtotal'), 2);
            $vatAmount = round($subtotal * ($vatRate / 100), 2);
            $total = $subtotal + $vatAmount;

            // Create Sale first
            $sale = Sale::create([
                'customer_id' => $order->customer_id,
                'user_id' => Auth::id(),
                'invoice_no' => $invoiceNo,
                'sale_date' => now()->toDateString(),
                'total_amount' => $total,
                'subtotal' => $subtotal,
                'vat_rate' => $vatRate,
                'vat_amount' => $vatAmount,
                'payment_status' => PaymentStatus::Paid,
                'remarks' => $order->remarks,
            ]);

            // Create Sale Items and deduct stock
            foreach ($order->items as $item) {
                $medicine = $item->medicine;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'medicine_id' => $item->medicine_id,
                    'quantity' => $item->quantity,
                    'selling_price' => $item->selling_price,
                    'subtotal' => $item->subtotal,
                ]);

                // Deduct stock AFTER sale creation
                $medicine->update([
                    'stock' => $medicine->stock - $item->quantity,
                ]);
            }

            return $sale;
        });
    }
}