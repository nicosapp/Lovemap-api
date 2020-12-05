<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
  use HasFactory;

  protected $guarded = [];

  public function locations()
  {
    return $this->belongsToMany(
      Term::class,
      'taxonomy_term',
      'taxonomy_id',
      'term_id',
    );
  }
}
