<?php

namespace App\Http\Controllers\Chats;

use App\Models\Chats\Chat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Chats\ChatResource;

class ChatController extends Controller
{
  public function index(Request $request)
  {
    //autorize
    return ChatResource::collection(
      $request->user()->chats()->latest('updated_at')->paginate(Chat::$pagination)
    );
  }

  public function show(Chat $chat,  Request $request)
  {
    //autorize
    return new ChatResource($chat);
  }

  public function store(Request $request)
  {
    //autorize

    $chat = Chat::create([
      'members' => "{$request->user()->id},{$request->get('user_id')}"
    ]);

    return $chat;
  }

  public function destroy(Chat $chat,  Request $request)
  {
    //authorize
    $chat->delete();
  }
}
