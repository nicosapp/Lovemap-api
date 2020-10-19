<?php

namespace App\Listeners\Social;


use Illuminate\Support\Facades\Mail;
use App\Mail\Social\SocialAccountLinked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Social\GitHubAccountWasLinked;

class SendGitHubLinkedEmail
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
   * @param  GitHubAccountWasLinked  $event
   * @return void
   */
  public function handle(GitHubAccountWasLinked $event)
  {
    dd('works');
    // Mail::to($event->user)->send(new SocialAccountLinked($event->user));
  }
}
