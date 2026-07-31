<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Medicine;
use App\Models\User;
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

    public function create(array $data): Sale
    {
        return DB::transaction(function () use ($data) {
            $duplicates = array_count_values($data['medicine_id']);
            foreach ($duplicates as $medicineId => $count) {
                if ($count > 1) {
                    throw new Exception('The same medicine cannot be added twice.');
                }
            }

            $total = 0;
            foreach ($data['medicine_id'] as $index => $medicineId) {
                $quantity = $data['quantity'][$index];
                $medicine = Medicine::findOrFail($medicineId);
                $sellingPrice = $medicine->selling_price;

                if ($medicine->stock < $quantity) {
                    throw new Exception("Insufficient stock for {$medicine->name}.");
                }

                $subtotal = $quantity * $sellingPrice;
                $total += $subtotal;
            }

            // Generate Invoice Number
            $lastSale = Sale::latest()->first();

            if (!$lastSale) {
                $invoiceNo = 'SAL-000001';
            } else {
                $number = (int) str_replace('SAL-', '', $lastSale->invoice_no);
                $number++;
                $invoiceNo = 'SAL-' . str_pad($number, 6, '0', STR_PAD_LEFT);
            }

            $sale = Sale::create([
                'customer_id' => $data['customer_id'],
                'user_id' => Auth::id(),
                'invoice_no' => $invoiceNo,
                'sale_date' => $data['sale_date'],
                'total_amount' => $total,
                'payment_status' => 'paid',
                'remarks' => $data['remarks'] ?? null,
            ]);

            foreach ($data['medicine_id'] as $index => $medicineId) {

                $medicine = Medicine::findOrFail($medicineId);
                $quantity = $data['quantity'][$index];
                $sellingPrice = $medicine->selling_price;
                $subtotal = $quantity * $sellingPrice;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'medicine_id' => $medicineId,
                    'quantity' => $quantity,
                    'selling_price' => $sellingPrice,
                    'subtotal' => $subtotal,
                ]);

                $medicine->update([
                    'stock' => $medicine->stock - $quantity,
                ]);
            }

            return $sale;           

        });
    }
}