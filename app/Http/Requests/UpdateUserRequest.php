<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && (
            auth()->id() === $this->user->id || 
            auth()->user()->hasRole('admin')
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users', 'email')->ignore($this->user->id),
                'max:255',
            ],
            'name' => [
                'sometimes',
                'string',
                'max:100',
                'min:2',
            ],
            'password' => [
                'sometimes',
                'nullable',
                'string',
                'min:8',
                'max:255',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            ],
            'role' => [
                'sometimes',
                'in:admin,vinar,worker,customer',
            ],
            'is_active' => [
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'This email is already in use',
            'password.regex' => 'Password must contain uppercase, lowercase, number, and special character',
            'role.in' => 'Invalid role selected',
        ];
    }
}
