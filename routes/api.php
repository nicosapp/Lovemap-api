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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return new UserResource($request->user());
});

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
  Route::post('signup', 'SignUpController');
  Route::post('signin', 'SignInController');
  Route::post('signout', 'SignOutController');

  Route::post('email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
  });
  // Route::get('email/verify/{numbers}', 'ApiVerificationController@verify')->name('verificationapi.verify');
  // Route::get('email/resend', 'ApiVerificationController@resend')->name('verificationapi.resend');
});


Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'users', 'namespace' => 'Users'], function () {
  Route::get('{user}', 'UserController@show');
  Route::patch('{user}', 'UserController@update');
  Route::patch('{user}/profile', 'UserController@updateProfile');
  Route::patch('{user}/password', 'UserController@updatePassword');
  Route::post('{user}/avatar', 'UserController@avatar');
});

Route::group(['prefix' => 'media', 'namespace' => 'Media'], function () {
  Route::get('config', 'MediaConfigController@index');
});
