<?php

namespace App\Models\Chats;

use App\Models\User;
use App\Events\Chats\ChatUpdated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
  use HasFactory;

  public static $pagination = 30;

  public function messages()
  {
    return $this->hasMany(Message::class);
  }

  public function users()
  {
    return User::whereIn('id', explode(',', $this->members));
  }

  public function friends()
  {
    return User::whereIn('id', explode(',', $this->members))->where('id', '!=', $this->me()->id);
  }

  public function me()
  {
    return Auth::user();
  }

  public function lastMessages()
  {
    return $this->messages()->sentLast();
  }

  public function unreadMessagesForUserId($userId)
  {
    return $this->messages()->where('user_id', '!=', $userId)->unread()->sentLast();
  }

  public function notifyChange()
  {
    $membersId = explode(',', $this->members);
    foreach ($membersId as $id) {
      broadcast(new ChatUpdated(User::find($id), $this))->toOthers();
    }
  }
}
