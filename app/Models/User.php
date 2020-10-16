<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use App\Models\Traits\WithMediaConversion;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Notifications\ApiResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
  use HasFactory, Notifiable, CanResetPassword, InteractsWithMedia, WithMediaConversion;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public static $mediaCollectionName = "avatars";

  public static function boot()
  {
    parent::boot();

    static::created(function (User $user) {
      $user->infos()->create();
    });
    static::creating(function (User $user) {
      $user->uuid = Str::uuid();
    });
  }

  public function getRouteKeyName()
  {
    return 'uuid';
  }

  public function sendPasswordResetNotification($token)
  {
    $this->notify(new ApiResetPasswordNotification($token));
  }

  // public function sendEmailVerificationNotification(){

  // }

  //Password Attribute
  public function setPasswordAttribute($password)
  {
    if (trim($password) === '') {
      return;
    }
    $this->attributes['password'] = Hash::make($password);
  }

  public function infos()
  {
    return $this->hasOne(UserInfo::class);
  }

  public function avatar()
  {
    return $this->getMedia(self::$mediaCollectionName)->first();
  }

  public function registerMediaConversions(?Media $media = null): void
  {
    $this->thumbnail();
  }
}
