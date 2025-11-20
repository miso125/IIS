<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTreatmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasPermissionTo('create treatment');
    }

    public function rules(): array
    {
        return [
            'Wine_row' => 'required|exists:wineyardrow,id_row',
            'type' => 'required|in:Postrek,Hnojenie,Rez,Zavlaženie,Iné',
            'treatment_product' => 'nullable|string|max:255',
            'concentration' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:1000',
            'date_time' => 'nullable|date|before_or_equal:today',
        ];
    }
}
