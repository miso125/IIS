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
        return auth()->check() && auth()->user()->hasPermissionTo('create purchase');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'items' => [
                'required',
                'array',
                'min:1',
            ],
            'items.*.wine_batch_id' => [
                'required',
                'integer',
                'exists:wine_batches,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
                'max:1000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'At least one wine must be selected',
            'items.min' => 'At least one wine must be selected',
            'items.*.wine_batch_id.exists' => 'Selected wine batch does not exist',
            'items.*.quantity.min' => 'Quantity must be at least 1',
        ];
    }
}
