<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 
 * Handles reguest for storing harvest
 */
class StoreHarvestRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Harvest::class);
    }


    /**
     * Get the validation rules that apply to the request.
     */
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

    /**
     * Error messages
     */
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
