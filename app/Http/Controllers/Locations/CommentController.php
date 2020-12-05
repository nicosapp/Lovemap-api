<?php

namespace App\Http\Controllers\Locations;

use App\Models\Comment;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
  public function index(Location $location, Request $request)
  {
    //autorize
    return $location->comments();
  }

  public function show(Comment $comment, Request $request)
  {
    //autorize
    return $comment;
  }

  public function store(Location $location, Request $request)
  {
    //autorize

    $this->validate($request, [
      'comment' => 'required|string',
    ]);

    $comment = $location->comments()->create([
      'comment' => 'New comment'
    ]);

    return $comment;
  }

  public function destroy(Comment $comment, Request $request)
  {
    //authorize
    $comment->delete();
  }
}
