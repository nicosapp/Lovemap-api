<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Social
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    if (!in_array(strtolower($request->service), array_keys(config('social.services')))) {
      return response()->json([
        'message' => 'Social is not activated!'
      ], 422);
    }
    return $next($request);
  }
}
