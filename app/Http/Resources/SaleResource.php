<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'invoice_no' => $this->invoice_no,
            'sale_date' => $this->sale_date,
            'total_amount' => $this->total_amount,
            'payment_status' => $this->payment_status,
            'remarks' => $this->remarks,

            'customer' => $this->customer
                ? [
                    'id' => $this->customer->id,
                    'name' => $this->customer->name,
                    'email' => $this->customer->email,
                ]
                : null,

            'user' => $this->user
                ? [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                ]
                : null,

            'items' => SaleItemResource::collection(
                $this->whenLoaded('items')
            ),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}