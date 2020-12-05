<?php

namespace App\Events\Chats;

use App\Http\Resources\Chats\ChatResource;
use App\Models\User;
use App\Models\Chats\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatUpdated implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $user;
  public $chat;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct(User $user, Chat $chat)
  {
    $this->user = $user;
    $this->chat = $chat;
  }

  public function broadcastWith()
  {
    return [
      'chat' => new ChatResource($this->chat)
    ];
  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return \Illuminate\Broadcasting\Channel|array
   */
  public function broadcastOn()
  {
    // return new PrivateChannel('channel-name');
    return new PrivateChannel("user.{$this->user->id}.chats.updated");
  }
}
