<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerMedicineResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'generic_name' => $this->generic_name,
            'brand' => $this->brand,
            'selling_price' => $this->selling_price,
            'stock' => $this->stock,
            'description' => $this->description,

            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],

            'unit' => [
                'id' => $this->unit->id,
                'name' => $this->unit->name,
            ],
        ];
    }
}