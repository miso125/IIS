<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWineyardRowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasPermissionTo('create winerow');
    }

    public function rules(): array
    {
        return [
            'variety' => 'required|string|max:100',
            'number_of_vines' => 'required|integer|min:1|max:500',
            'planting_year' => 'required|integer|min:1900|max:' . now()->year,
            'colour' => 'required|in:white,red,pink',
        ];
    }

    public function messages(): array
    {
        return [
            'variety.required' => 'Odroda viniča je povinná',
            'number_of_vines.required' => 'Počet hlav je povinný',
            'colour.in' => 'Vybrala si neplatnú farbu',
        ];
    }
}
