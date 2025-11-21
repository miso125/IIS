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
        return auth()->check() && auth()->user()->hasPermissionTo('create user');
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
            'login.required' => 'Login is required',
            'login.unique' => 'This login is already taken',
            'login.regex' => 'Login can only contain letters, numbers, dots, dashes, and underscores',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be valid',
            'email.unique' => 'This email is already registered',
            'name.required' => 'Full name is required',
            'password.required' => 'Password is required',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&)',
            'role.in' => 'Invalid role selected',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active', true),
        ]);
    }
}
