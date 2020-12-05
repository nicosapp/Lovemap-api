<?php

namespace App\Http\Resources\Chats;

use App\Http\Resources\Chat\MessageResource;
use App\Http\Resources\Chats\ChatUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'friend' => new ChatUserResource($this->friends()->first()),
      'me' =>  new ChatUserResource($this->me()),
      'updated_at' => $this->updated_at,
      'created_at' => $this->created_at,
      'last_message' => new MessageResource($this->lastMessages()->first())
    ];
  }
}
