<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Auth::routes([
  'register' => false,
  'verify' => true,
  'reset' => true
]);

Route::get('sanctum/csrf-cookie', function () {
  return redirect('sanctum/csrf-cookie');
});

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
  Route::post('signup', 'SignUpController');
  Route::post('signin', 'SignInController');
  Route::post('signout', 'SignOutController');

  // Route::get('email/verify/{numbers}', 'ApiVerificationController@verify')->name('verificationapi.verify');
  // Route::get('email/resend', 'ApiVerificationController@resend')->name('verificationapi.resend');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return new UserResource($request->user());
});
