<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'medicine' => $this->medicine
                ? [
                    'id' => $this->medicine->id,
                    'name' => $this->medicine->name,
                ]
                : null,
            'quantity' => $this->quantity,
            'purchase_price' => $this->purchase_price,
            'selling_price' => $this->selling_price,
            'subtotal' => $this->subtotal,
            'batch_no' => $this->batch_no,
            'expiry_date' => $this->expiry_date,
        ];
    }
}