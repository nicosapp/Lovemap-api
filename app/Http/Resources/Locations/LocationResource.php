<?php

namespace App\Http\Resources\Locations;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
      'title' => $this->title,
      'lat' => $this->lat,
      'lng' => $this->lng,
      'comment' => $this->comment,
      'partner' => $this->partner,
      'duration' => $this->duration,
      'time' => $this->time,
      'date' => $this->date,
      'rating' => $this->rating,
      'country' => $this->country,
      'city' => $this->city,
      'images' =>  MediaResource::collection($this->images())
    ];
  }
}
