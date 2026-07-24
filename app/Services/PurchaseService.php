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

            $total = 0;

            foreach ($data['medicine_id'] as $index => $medicineId) {
                $quantity = $data['quantity'][$index];
                $purchasePrice = $data['purchase_price'][$index];

                $subtotal = $quantity * $purchasePrice;
                $total += $subtotal;
            }

            $purchase = Purchase::create([
                'supplier_id' => $data['supplier_id'],
                'invoice_no' => $data['invoice_no'],
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