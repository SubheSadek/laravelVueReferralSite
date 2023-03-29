<?php

namespace App\Http\Controllers\Web\Referral;

use Illuminate\Support\Str;

class ReferralService
{
    public function formateRequest($request)
    {
        $data = [];
        $data['search'] = $request['search'] ?? null;
        $data['pageSize'] = $request['pageSize'] ?? 10;

        return $data;
    }

    public function formatReferralData($vData)
    {
        $vData['referred_by'] = auth()->id();
        $vData['code'] = Str::uuid();

        return $vData;
    }

    public function checkReferralStatus(array $vData)
    {
        if (auth()->user()->total_referred >= 10) {
            return withError('Max referred Quota exceeded', 400);
        }

        return false;
    }
}
