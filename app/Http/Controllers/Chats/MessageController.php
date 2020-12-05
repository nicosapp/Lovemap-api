<?php

namespace App\Http\Controllers\Chats;

use App\Models\Chats\Chat;
use Illuminate\Http\Request;
use App\Models\Chats\Message;

use App\Events\Chats\ChatUpdated;
use App\Events\Chats\MessageSent;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\MessageResource;

class MessageController extends Controller
{
  public function index(Chat $chat, Request $request)
  {
    //autorize
    $chat->unreadMessagesForUserId($request->user()->id)->markAsRead();

    return MessageResource::collection(
      $chat->messages()->sentLast()->paginate(Message::$pagination)
    );
  }

  public function show(Message $message,  Request $request)
  {
    //autorize
    return new MessageResource($message);
  }

  public function store(Chat $chat,  Request $request)
  {
    //autorize

    $this->validate($request, [
      'message' => 'required|string',
      'is_member_online' => 'nullable|boolean'
    ]);

    $message = $chat->messages()->create([
      'message' => $request->get('message'),
      'user_id' => $request->user()->id,
      'read_at' =>  $request->get('is_member_online') ? now() : null
    ]);

    $chat->notifyChange();

    broadcast(new MessageSent($request->user(), $chat, $message))->toOthers();

    return new MessageResource($message);
  }

  public function destroy(Message $message,  Request $request)
  {
    //authorize
    $message->delete();
  }
}
