<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleItemResource extends JsonResource
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
            'selling_price' => $this->selling_price,
            'subtotal' => $this->subtotal,
        ];
    }
}