<?php

namespace App\Http\Controllers\Web\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|max:255|unique:users,email',
            'password' => 'nullable|string|min:6|confirmed',
            'referred_code' => 'nullable|uuid',
        ];

        return $rules;
    }

    public function messages()
    {
        return [];
    }
}
