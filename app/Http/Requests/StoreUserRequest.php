<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasPermissionTo('create user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => 'required|string|unique:user,login|max:50|regex:/^[a-zA-Z0-9_]+$/',
            'password_hash' => 'required|string|min:8|max:255',
            'email' => 'required|email|unique:user,email|max:255',
            'name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'role' => 'required|in:admin,winemaker,worker,customer,visitor',
        ];
    }
    
    public function messages(): array
    {
        return [
            'login.unique' => 'Tento login je už zaregistrovaný.',
            'login.regex' => 'Login môže obsahovať len písmená, čísla a podčiarkovník.',
            'email.unique' => 'Tento email je už zaregistrovaný.',
            'role.in' => 'Vybrala si neplatnú rolu.',
        ];
    }
}
