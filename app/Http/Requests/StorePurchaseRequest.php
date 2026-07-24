<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Purchase Header
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_no' => 'nullable|string|max:255',
            'purchase_date' => 'required|date',
            'remarks' => 'nullable|string|max:1000',

            // Arrays
            'medicine_id' => 'required|array|min:1',
            'medicine_id.*' => 'required|exists:medicines,id',

            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',

            'purchase_price' => 'required|array|min:1',
            'purchase_price.*' => 'required|numeric|min:0.01',

            'selling_price' => 'required|array|min:1',
            'selling_price.*' => 'required|numeric|min:0.01',

            'batch_no' => 'nullable|array',
            'batch_no.*' => 'nullable|string|max:100',

            'expiry_date' => 'required|array',
            'expiry_date.*' => 'required|date|after:today',
        ];
    }

    public function messages(): array
    {
        return [
            'supplier_id.required' => 'Please select a supplier.',
            'purchase_date.required' => 'Please select the purchase date.',

            'medicine_id.required' => 'Please add at least one medicine.',
            'medicine_id.*.required' => 'Please select a medicine.',

            'quantity.*.required' => 'Please enter the quantity.',
            'quantity.*.min' => 'Quantity must be greater than 0.',

            'purchase_price.*.required' => 'Please enter the purchase price.',
            'purchase_price.*.min' => 'Purchase price must be greater than 0.',

            'selling_price.*.required' => 'Please enter the selling price.',
            'selling_price.*.min' => 'Selling price must be greater than 0.',

            'expiry_date.*.required' => 'Please select an expiry date.',
            'expiry_date.*.after' => 'Expiry date must be in the future.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $purchasePrices = $this->purchase_price ?? [];
            $sellingPrices = $this->selling_price ?? [];

            foreach ($purchasePrices as $index => $purchasePrice) {
                if (
                    isset($sellingPrices[$index], $purchasePrices[$index]) &&
                    is_numeric($sellingPrices[$index]) &&
                    is_numeric($purchasePrices[$index]) &&
                    $sellingPrices[$index] < $purchasePrices[$index]
                ) {
                    $validator->errors()->add(
                        "selling_price.$index",
                        'Selling price must be greater than or equal to the purchase price.'
                    );
                }
            }
        });
    }
}