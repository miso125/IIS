<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTreatmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasPermissionTo('create treatment');
    }

    public function rules(): array
    {
        return [
            'wine_row' => 'required|exists:wineyardrow,id_row',
            'type' => 'required|in:Postrek,Hnojenie,Rez,Zavlaženie,Iné',
            'treatment_product' => 'nullable|string|max:255',
            'concentration' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:1000',
            'date_time' => 'nullable|date|before_or_equal:today',
        ];
    }

    public function messages(): array
    {
        return [
            'wine_row.exists' => 'Selected vineyard does not exist',
            'type.in' => 'Invalid treatment type',
            'concentration.numeric' => 'Concentration must be a valid number',
        ];
    }
}
