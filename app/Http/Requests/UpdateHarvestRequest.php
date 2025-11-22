<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHarvestRequest extends FormRequest
{
    public function authorize(): bool
    {
        $harvest = $this->route('harvest'); // get model from route
        return $harvest ? $this->user()->can('update', $harvest) : false;
    }

    public function rules(): array
    {
        return [
            'wine_row' => 'required|exists:wineyardrow,id_row',
            'weight_grapes' => 'required|numeric|min:0',
            'variety' => 'required|string|max:255',
            'sugariness' => 'nullable|numeric|min:0',
            'date_time' => 'required|date',
            'notes' => 'nullable|string',
        ];
    }
}
