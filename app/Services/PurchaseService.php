<?php

namespace App\Services;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Medicine;
use Illuminate\Support\Facades\DB;

class PurchaseService
{
    public function getAll()
    {
        return Purchase::with('supplier')
            ->latest()
            ->paginate(10);
    }

    public function create(array $data): Purchase
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
                $purchasePrice = $data['purchase_price'][$index];

                $subtotal = $quantity * $purchasePrice;
                $total += $subtotal;
            }

            // Generate Invoice Number
            $lastPurchase = Purchase::latest()->first();

            if (!$lastPurchase) {
                $invoiceNo = 'PUR-000001';
            } else {
                $number = (int) str_replace('PUR-', '', $lastPurchase->invoice_no);
                $number++;
                $invoiceNo = 'PUR-' . str_pad($number, 6, '0', STR_PAD_LEFT);
            }

            $purchase = Purchase::create([
                'supplier_id' => $data['supplier_id'],
                'invoice_no' => $invoiceNo,
                'purchase_date' => $data['purchase_date'],
                'total_amount' => $total,
                'remarks' => $data['remarks'] ?? null,
            ]);

            foreach ($data['medicine_id'] as $index => $medicineId) {
                $subtotal = $data['quantity'][$index] * $data['purchase_price'][$index];

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'medicine_id' => $medicineId,
                    'quantity' => $data['quantity'][$index],
                    'purchase_price' => $data['purchase_price'][$index],
                    'selling_price' => $data['selling_price'][$index],
                    'subtotal' => $subtotal,
                    'batch_no' => $data['batch_no'][$index] ?? null,
                    'expiry_date' => $data['expiry_date'][$index] ?? null,
                ]);
                $medicine = Medicine::findOrFail($medicineId);
                $medicine->update([
                    'selling_price' => $data['selling_price'][$index],
                    'stock' => $medicine->stock + $data['quantity'][$index],
                ]);
            }

            return $purchase;
        });
    }
}