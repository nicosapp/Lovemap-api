<?php

namespace App\Models\Chats;

use App\Models\User;
use App\Models\Chats\Chat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
  use HasFactory;

  protected $dates = [
    'updated_at',
    'created_at'
  ];

  public static $pagination = 30;

  protected $guarded = [];

  protected $touches = ['chat'];  // or $chat->touch()

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function chat()
  {
    return $this->belongsTo(Chat::class);
  }

  // public function markAsRead()
  // {
  //   $this->forceFill([
  //     'read_at' => Carbon::now(),
  //   ])->save();
  //   // Carbon::now()->toDateTimeString()
  //   // Carbon::now()->timestamp()
  // }

  public function isMe()
  {
    return $this->user_id === optional(Auth::user())->id;
  }

  public function isRead()
  {
    return !!$this->read_at;
  }

  public function scopeSentLast($query)
  {
    return $query->latest('created_at');
  }

  public function scopeMarkAsRead($query)
  {
    $query->update(['read_at' => now()]);
  }

  public function scopeUnread($query)
  {
    $query->whereNull('read_at');
  }
}
