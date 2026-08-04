<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20|regex:/^\+?[0-9\s\-\(\)]{7,20}$/',
            'email' => ['required', 'email', 'max:255', Rule::unique('customers')->ignore($this->route('customer'))],
            'address' => 'nullable|string|max:1000',
            'status' => 'nullable|boolean',
        ];
    }
}