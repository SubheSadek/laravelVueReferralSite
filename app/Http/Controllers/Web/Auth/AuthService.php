<?php

namespace App\Http\Controllers\Web\Auth;

use App\Models\Referral;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function formatRegistrationData($vData)
    {
        $vData['password'] = Hash::make($vData['password']);
        $vData['referred_code'] = $vData['referred_code'] ?? null;

        return $vData;
    }

    public function checkOrFindReferral($referred_code, $email)
    {
        if (! $referred_code) {
            return 0;
        }

        $referral = Referral::where([
            'code' => $referred_code,
            'email' => $email,
            'is_registered' => 0,
        ])->first();

        if (! $referral) {
            return 2;
        }

        return $referral;
    }
}
