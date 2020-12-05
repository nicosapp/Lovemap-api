<?php

use App\Models\Chats\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
  return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{id}', function ($user, $id) {
  if (Chat::where('id', $id)->where('members', 'LIKE', "%{$user->id}%")->exists()) {
    return ['id' => $user->id, 'name' => $user->name];
  }
  // return Auth::check();
  // return true;
});

Broadcast::channel('user.{id}.chats.updated', function ($user) {
  return Auth::check();
});
