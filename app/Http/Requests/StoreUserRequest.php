<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'role' => ['required', 'string', Rule::in(['admin', 'patient'])],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    /**
     * Set the attributes for localization.
     */
    public function attributes(): array
    {
        return [
            'name' => __('users.name.label'),
            'email' => __('users.email.label'),
            'role' => __('users.role.label'),
            'password' => __('users.password.label'),
        ];
    }
}
