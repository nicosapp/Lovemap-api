<?php

namespace App\Events\Chats;

use App\Models\User;
use App\Models\Chats\Chat;
use App\Models\Chats\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use App\Http\Resources\Chat\MessageResource;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $user;
  public $chat;
  public $message;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct(User $user, Chat $chat, Message $message)
  {
    $this->user = $user;
    $this->chat = $chat;
    $this->message = $message;
  }

  public function broadcastWith()
  {
    return [
      'message' => new MessageResource($this->message)
    ];
  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return \Illuminate\Broadcasting\Channel|array
   */
  public function broadcastOn()
  {
    // return new Channel("chat.{$this->chat->id}");
    return new PresenceChannel("chat.{$this->chat->id}");
  }
}
