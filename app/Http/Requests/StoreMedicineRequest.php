<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMedicineRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('medicines')->where(function ($query) {
                    return $query->where('brand', request('brand'));
                }),
            ],
            'generic_name' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'reorder_level' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ];
    }
}
