<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Auth\Requests\LoginRequest;
use App\Http\Controllers\Web\Auth\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    private $authSevice;

    public function __construct(AuthService $authService)
    {
        $this->authSevice = $authService;
    }

    public function register(RegistrationRequest $request)
    {
        $formated_data = $this->authSevice->formatRegistrationData($request->validated());
        $checkOrFindReferral = $this->authSevice->checkOrFindReferral($formated_data['referred_code'], $formated_data['email']);
        unset($formated_data['referred_code']);

        if ($checkOrFindReferral === 2) {
            return withError('Invalid referral code', 400);
        }

        DB::beginTransaction();
        try {
            $user = User::create($formated_data);
            if ($checkOrFindReferral) {
                $checkOrFindReferral->update(['is_registered' => 1]);
                User::findOrFail($checkOrFindReferral->referred_by)->increment('successful_referred');
            }
            DB::commit();
            Auth::login($user);

            return withSuccess(null, 'Registration Successful!');
        } catch (\Exception $e) {
            DB::rollBack();

            return withError('Registration Failed!', 400);
        }
    }

    public function login(LoginRequest $request)
    {
        $vData = $request->validated();
        if (Auth::attempt($vData)) {
            return withSuccess(null, 'Login Successfully!');
        }

        return withError('Email or password is incorrect!', 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerateToken();

        return withSuccess(null, 'Logout Successfully!');
    }
}
