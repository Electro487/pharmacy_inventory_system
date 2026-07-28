<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Medicine;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class SaleService
{
    public function getAll()
    {
        return Sale::with(['customer', 'user'])
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
                $sellingPrice = $data['selling_price'][$index];
                $medicine = Medicine::findOrFail($medicineId);

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
                $subtotal = $quantity * $data['selling_price'][$index];

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'medicine_id' => $medicineId,
                    'quantity' => $quantity,
                    'selling_price' => $data['selling_price'][$index],
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