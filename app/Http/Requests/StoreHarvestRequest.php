<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHarvestRequest extends FormRequest
{

    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Harvest::class);
    }


    public function rules(): array
    {
        return [
            'wine_row' => [
                'required',
                'exists:wineyardrow,id_row',
            ],
            'weight_grapes' => [
                'required',
                'numeric',
                'min:0.1',
                'max:100000',
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
            'date_time' => [
                'required',
                'date',
                'before_or_equal:now',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'wine_row.exists' => 'Selected vineyard row does not exist',
            'weight_grapes.numeric' => 'Grape weight must be a valid number',
            'sugariness.numeric' => 'Sugar content must be a valid number',
            'date_time.before_or_equal' => 'Harvest date cannot be in the future',
        ];
    }
}
