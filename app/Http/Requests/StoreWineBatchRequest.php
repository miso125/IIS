<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWineBatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasPermissionTo('create winebatch');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'harvest' => [
                'required',
                'integer',
                'exists:harvests,id',
            ],
            'vintage' => [
                'required',
                'integer',
                'min:1900',
                'max:' . now()->year,
            ],
            'variety' => [
                'required',
                'string',
                'max:100',
            ],
            'sugariness' => [
                'required',
                'numeric',
                'min:0',
                'max:30',
            ],
            'alcohol_percentage' => [
                'required',
                'numeric',
                'min:0',
                'max:25',
            ],
            'number_of_bottles' => [
                'required',
                'integer',
                'min:1',
                'max:100000',
            ],
            'date_time' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'harvest.exists' => 'Selected harvest does not exist',
            'alcohol_percentage.max' => 'Alcohol percentage cannot exceed 25%',
            'number_of_bottles.min' => 'Must produce at least 1 bottle',
        ];
    }
}
