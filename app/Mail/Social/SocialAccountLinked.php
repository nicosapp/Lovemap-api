<?php

namespace App\Mail\Social;

use App\Models\User;
use App\Models\UserSocial;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SocialAccountLinked extends Mailable
{
  use Queueable, SerializesModels;

  public $theme = 'email';

  public $user;
  public $social;
  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct(User $user, UserSocial $social)
  {
    $this->user = $user;
    $this->social = $social;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->subject('Social account linked')
      ->with([
        'introLines' => [
          'Your __' . config("social.services.{$this->social->service}.name", 'Social') . '__ account is now linked!'
        ]
      ])
      ->markdown('email.mail');
  }
}
