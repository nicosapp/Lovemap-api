<?php

namespace App\Models;

use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use App\Mail\Social\SocialAccountLinked;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSocial extends Model
{
  use HasFactory;

  protected $table = 'users_social';

  protected $fillable = ['social_id', 'service'];

  public static function boot()
  {
    parent::boot();

    static::created(function (UserSocial $userSocial) {
      Mail::to($userSocial->user)->send(new SocialAccountLinked($userSocial->user, $userSocial));
    });
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
