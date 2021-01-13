<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Mail\Social\SocialAccountLinked;

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

Auth::routes([
  'register' => false,
  'verify' => true,
  'reset' => true
]);

Route::get('login/{service}', 'Auth\SocialLoginController@redirect');
Route::get('login/{service}/callback', 'Auth\SocialLoginController@callback');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
  return ['test' => 'it works'];
});
// Route::get('send', function () {
//   $user = User::where('id', 8)->first();
//   Mail::to($user)->send(new SocialAccountLinked($user, $user->social()->first()));
//   return response()->json(['message' => 'send']);
// });

// Route::get('email', function () {
//   $user = User::where('id', 8)->first();
//   return new SocialAccountLinked($user,  $user->social()->first());
// });
