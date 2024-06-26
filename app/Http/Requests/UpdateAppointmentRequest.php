<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
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
            'receipt' => ['required', 'image', 'max:2048'],
        ];
    }

    /**
     * Set attributes for localization.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'receipt' => __('appointments.receipt.placeholder'),
        ];
    }
}
