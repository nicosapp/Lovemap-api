<?php

namespace App\Models;

use App\Models\Comment;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\WithMediaConversion;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Location extends Model  implements HasMedia
{
  use HasFactory, InteractsWithMedia, WithMediaConversion;

  protected $guarded = [];

  public static $mediaCollectionName = "locations";

  public function user()
  {
    return $this->belongsTo(Location::class);
  }

  public function comments()
  {
    return $this->hasMany(Comment::class);
  }

  public function tags()
  {
    return $this->belongsToMany(
      Taxonomy::class,
      'location_taxonomy',
      'location_id',
      'taxonomy_id'
    )->where('taxonomy', 'tag')->withTimestamps();
  }

  public function registerMediaConversions(?Media $media = null): void
  {
    $this->thumbnail();
  }

  public function images()
  {
    return $this->getMedia(self::$mediaCollectionName);
  }
}
