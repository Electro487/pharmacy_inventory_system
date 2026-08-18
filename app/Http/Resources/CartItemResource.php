<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'medicine_id' => $this->medicine_id,
            'quantity' => $this->quantity,

            'medicine' => [
                'id' => $this->medicine->id,
                'name' => $this->medicine->name,
                'generic_name' => $this->medicine->generic_name,
                'brand' => $this->medicine->brand,
                'selling_price' => $this->medicine->selling_price,
            ],
        ];
    }
}