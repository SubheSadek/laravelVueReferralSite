<?php

namespace App\Http\Controllers\Web\Referral;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Referral\Requests\CreateReferralRequest;
use App\Http\Controllers\Web\Referral\Resources\ReferralListResource;
use App\Mail\SendInvitationEmail;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReferralController extends Controller
{
    private $referralService;

    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }

    public function createReferral(CreateReferralRequest $request)
    {
        $vData = $this->referralService->formatReferralData($request->validated());
        $check = $this->referralService->checkReferralStatus($vData);
        if ($check) {
            return $check;
        }

        DB::beginTransaction();
        try {
            $referral = Referral::create($vData);
            User::findOrFail($referral->referred_by)->increment('total_referred');
            Mail::to($referral->email)->queue(new SendInvitationEmail($referral->load(['referredBy'])));
            DB::commit();

            return withSuccess($referral->load(['referredBy']), 'Invitation Sent Successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return withError($e->getMessage(), 400);
        }
    }

    public function referralList(Request $request)
    {
        $request_data = $this->referralService->formateRequest($request);

        return ReferralListResource::collection(
            Referral::filter($request_data['search'])
                ->with('referredBy')
                ->latest('id')->paginate($request_data['pageSize'])
        );
    }
}
