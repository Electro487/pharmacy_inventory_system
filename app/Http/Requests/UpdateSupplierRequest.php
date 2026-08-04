<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('suppliers', 'name')->ignore($this->route('supplier'))],
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30|regex:/^\+?[0-9\s\-\(\)]{7,20}$/',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'status' => 'nullable|boolean',
        ];
    }
}
