<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogoutSuccess
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   *
   * @param  Logout  $event
   * @return void
   */
  public function handle(Logout $event)
  {
    $user = User::find($event->user->id);
    $user->toggleOnline(false);
  }
}
