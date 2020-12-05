<?php

namespace App\Http\Controllers\Locations;

use App\Models\User;
use App\Media\FileSize;
use App\Media\MimeTypes;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResource;
use App\Http\Resources\Locations\LocationResource;
use App\Http\Resources\Locations\LocationLightResource;

class LocationController extends Controller
{
  public function __construct()
  {
    // $this->middleware(['auth:sanctum']);
  }

  public function show(Request $request, Location $location)
  {
    //authorize

    return new LocationResource($location);
  }

  public function index(Request $request)
  {
    //authorize
    $user = User::get()->first();
    return LocationLightResource::collection($user->locations()->get());
  }

  public function store(Request $request, Location $location)
  {
    $this->validate($request, [
      'title' => 'required|string',
      'lat' => 'numeric|required',
      'lng' => 'numeric|required',
      'comment' => 'string|nullable',
      'partner' => 'string|nullable',
      'city' => 'string|nullable',
      'country' => 'string|nullable',
      'date' => 'nullable|date_format:Y-m-d',
      'time' => 'nullable|date_format:H:i',
      'duration' => 'string|nullable',
      'rating' => 'integer|max:5|min:0|nullable',
      'image.*' => 'nullable|file|max:' . FileSize::max_file_size()['kb'] . '|mimetypes:' . implode(',', MimeTypes::$image)
    ]);

    $user = User::get()->first();
    $location = $user->locations()->create(
      $request->only('title', 'lat', 'lng', 'comment', 'partner', 'city', 'country', 'date', 'time', 'duration', 'rating')
    );

    if ($request->file('image')) {
      // $location->clearMediaCollection(User::$mediaCollectionName);
      $media = $location->addMedia($request->file('image')[0])->setName('image')->toMediaCollection(Location::$mediaCollectionName);
    }

    return new LocationResource($location);
  }

  public function update(Request $request, Location $location)
  {
    //authorization
    // $this->authorize('update', $term);
    //validate

    $this->validate($request, [
      'title' => 'sometimes|required|string',
      'comment' => 'string|nullable',
      'partner' => 'string|nullable',
      'city' => 'string|nullable',
      'country' => 'string|nullable',
      'date' => 'nullable|date_format:Y-m-d',
      'time' => 'nullable|date_format:H:i',
      'duration' => 'integer|nullable',
      'rating' => 'integer|max:5|min:0|nullable',
    ]);

    $location->update(
      $request->only('title', 'comment', 'partner', 'city', 'country', 'date', 'time', 'duration', 'rating')
    );
    return new LocationResource($location);
  }

  public function destroy(Request $request, Location $location)
  {
    //authorization
    // $this->authorize('destroy', $term);

    $location->delete();
  }
}
