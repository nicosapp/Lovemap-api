<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;



class SocialLoginController extends Controller
{

  public function __construct()
  {
    $this->middleware(['social', 'guest']);
  }

  public function redirect($service, Request $request)
  {
    $url = Socialite::driver($service)->stateless()->redirect()->getTargetUrl();

    return response()->json([
      'data' => [
        'url' => $url
      ]
    ]);
  }

  public function callback($service, Request $request)
  {
    $serviceUser = Socialite::driver($service)->stateless()->user();

    $user = $this->getExistingUser($serviceUser, $service);

    if (!$user) {
      $user = User::create([
        'name' => $serviceUser->getName(),
        'email' => $serviceUser->getEmail(),
        'password' => Str::random(8)
      ]);

      // $user->infos()->update(['avatar_url' => $serviceUser->getAvatar()]);
    }

    if ($this->needsToCreateSocial($user, $service)) {
      $user->social()->create([
        'social_id' => $serviceUser->getId(),
        'service' => $service
      ]);
    }
    Auth::login($user, false);

    return redirect(config('client.routes.account'));
  }

  protected function needsToCreateSocial(User $user, $service)
  {
    return !$user->hasSocialLinked($service);
  }

  protected function getExistingUser($serviceUser, $service)
  {
    return User::where('email', $serviceUser->getEmail())->orWhereHas('social', function ($q) use ($serviceUser, $service) {
      $q->where('social_id', $serviceUser->getId())->where('service', $service);
    })->first();
  }
}
