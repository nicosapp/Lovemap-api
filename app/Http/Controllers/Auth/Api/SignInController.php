<?php

namespace App\Http\Controllers\Auth\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SignInController extends Controller
{

  public function __construct()
  {
    $this->middleware(['auth:sanctum'])->except('login');
  }

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
      'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
      throw ValidationException::withMessages([
        'email' => ['The provided credentials are incorrect.'],
      ]);
    }

    return response()->json([
      'data' => [
        'access_token' => $user->createToken($request->device_name)->plainTextToken,
        'token_type' => 'Bearer'
      ]
    ], 200);
  }

  public function logout(Request $request)
  {
    if (!$request->user()) {
      return response()->json([
        'message' => 'Unauthenticated',
      ], 401);
    }
    return $request->user()->tokens()->delete();
  }
}
