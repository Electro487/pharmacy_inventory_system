<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'invoice_no' => $this->invoice_no,
            'purchase_date' => $this->purchase_date,
            'total_amount' => $this->total_amount,
            'remarks' => $this->remarks,
            'status' => $this->status,

            'supplier' => $this->supplier
                ? [
                    'id' => $this->supplier->id,
                    'name' => $this->supplier->name,
                    'company' => $this->supplier->company,
                ]
                : null,

            'items' => PurchaseItemResource::collection($this->whenLoaded('items')),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}