<?php

namespace App\Http\Resources\Chat;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
      'user_id' => $this->user_id,
      'me' => $this->isMe(),
      'message' => $this->message,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
      'is_read' => $this->isRead()
    ];
  }
}
