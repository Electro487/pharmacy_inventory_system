<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'sale_date' => 'required|date',
            'remarks' => 'nullable|string',

            'medicine_id' => 'required|array|min:1',
            'medicine_id.*' => 'required|exists:medicines,id',

            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',

        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'Please select a customer.',
            'sale_date.required' => 'Please select the sale date.',

            'medicine_id.required' => 'Please add at least one medicine.',
            'medicine_id.*.required' => 'Please select a medicine.',

            'quantity.*.required' => 'Please enter the quantity.',
            'quantity.*.min' => 'Quantity must be greater than 0.',
        ];
    }
}
