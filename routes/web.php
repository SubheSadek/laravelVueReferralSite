<?php

use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Referral\ReferralController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'web'], function ($route) {
    $route->controller(AuthController::class)->prefix('auth')->group(function ($route) {
        $route->post('register', 'register')->name('web.register')->middleware('guest');
        $route->post('login', 'login')->name('web.login')->middleware('guest');
        $route->get('logout', 'logout')->name('web.logout')->middleware('auth');
    });

    $route->controller(ReferralController::class)->prefix('referral')->middleware('auth')->group(function ($route) {
        $route->post('create-referral', 'createReferral')->name('referral.registere');
        $route->get('referral-list', 'referralList')->name('referral.list')->middleware('admin.user');
    });
});

Route::get('/web/{all?}', function () {
    return withError('No record Found!', 404);
})->where(['all' => '.*']);

Route::get('/{all?}', function () {
    return view('welcome');
})->where(['all' => '.*']);
