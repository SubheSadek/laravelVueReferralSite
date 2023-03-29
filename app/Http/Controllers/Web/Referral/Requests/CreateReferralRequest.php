<?php

namespace App\Http\Controllers\Web\Referral\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReferralRequest extends FormRequest
{
    /**
     * Determine if the user is referralorized to make this request.
     *
     * @return bool
     */
    public function referralorize()
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
            'email' => [
                'nullable',
                'string',
                'max:255',
                'unique:referrals', 'email',
                'unique:users,email',
            ],
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'email.unique' => 'This email is already referred or used.',
        ];
    }
}
