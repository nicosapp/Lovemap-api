<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

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

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return new UserResource($request->user());
});

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
  Route::post('signup', 'SignUpController');
  Route::get('signin/{service}', 'SocialLoginController@redirect');
  Route::get('signin/{service}/callback', 'SocialLoginController@callback');
});


Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'users', 'namespace' => 'Users'], function () {
  Route::get('{user}', 'UserController@show');
  Route::patch('{user}', 'UserController@update');
  Route::patch('{user}/profile', 'UserController@updateProfile');
  Route::patch('{user}/password', 'UserController@updatePassword');
  Route::post('{user}/avatar', 'UserController@avatar');
});

Route::group(['prefix' => 'locations', 'namespace' => 'Locations'], function () {
  Route::get('', 'LocationController@index');
  Route::get('{location}', 'LocationController@show');
  Route::post('', 'LocationController@store');
  Route::patch('{location}', 'LocationController@update');
  Route::delete('{location}', 'LocationController@destroy');

  // Route::group(['prefix' => '{location}/comments', 'namespace' => 'Locations'], function () {
  //   Route::get('', 'CommmentController@index');
  //   Route::get('{comment}', 'CommmentController@show');
  //   Route::post('', 'CommmentController@store');
  //   Route::delete('{comment}', 'CommmentController@destroy');
  // });
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'chats', 'namespace' => 'Chats'], function () {
  Route::get('', 'ChatController@index');
  Route::get('{chat}', 'ChatController@show');
  Route::post('', 'ChatController@store');
  // Route::patch('{chat}', 'ChatController@update');
  Route::delete('{chat}', 'ChatController@destroy');

  Route::group(['prefix' => '{chat}/messages'], function () {
    Route::get('', 'MessageController@index');
    Route::get('{message}', 'MessageController@show');
    Route::post('', 'MessageController@store');
    Route::delete('{message}', 'MessageController@destroy');
  });
});


Route::group(['prefix' => 'media', 'namespace' => 'Media'], function () {
  Route::get('config', 'MediaConfigController@index');
});
