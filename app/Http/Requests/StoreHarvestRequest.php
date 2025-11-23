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
            'date_time' => [
                'required',
                'date',
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
