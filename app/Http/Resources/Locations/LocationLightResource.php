<?php

namespace App\Http\Resources\Locations;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationLightResource extends JsonResource
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
      'partner' => $this->partner,
      'rating' => $this->rating
    ];
  }
}
