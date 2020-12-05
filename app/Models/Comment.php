<?php

namespace App\Models;

use App\Models\User;
use App\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
  use HasFactory;

  protected $fillable = ['comment'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function location()
  {
    return $this->belongsTo(Location::class);
  }
}
