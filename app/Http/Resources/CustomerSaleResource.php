<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerSaleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'invoice_no' => $this->invoice_no,
            'sale_date' => $this->sale_date,
            'subtotal' => $this->subtotal,
            'vat_rate' => $this->vat_rate,
            'vat_amount' => $this->vat_amount,
            'total_amount' => $this->total_amount,
            'payment_status' => $this->payment_status,
            'items' => SaleItemResource::collection(
                $this->whenLoaded('items')
            ),
        ];
    }
}