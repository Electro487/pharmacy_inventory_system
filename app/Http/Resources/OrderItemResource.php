<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'medicine' => $this->medicine?->name,
            'quantity' => $this->quantity,
            'selling_price' => $this->selling_price,
            'subtotal' => $this->subtotal,
        ];
    }
}