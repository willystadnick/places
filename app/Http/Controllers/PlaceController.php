<?php

namespace App\Http\Controllers;
use App\Http\Requests\StorePlaceRequest;
use App\Models\Place;
use App\Http\Resources\PlaceResource;
use Illuminate\Support\Str;

class PlaceController extends Controller
{
    public function index()
    {
        $places = Place::all();
        return PlaceResource::collection($places);
    }

    public function show(Place $place)
    {
        return new PlaceResource($place);
    }

    public function store(StorePlaceRequest $request)
    {
        $validatedData = $request->validated();

        $slug = Str::slug($validatedData['name']);

        while (Place::where('slug', $slug)->exists()) {
            $slug = Str::slug($validatedData['name']) . '-' . Str::random(5);
        }

        $place = Place::create(array_merge($validatedData, ['slug' => $slug]));
        return response()->json(new PlaceResource($place), 201);
    }

    public function update(StorePlaceRequest $request, Place $place)
    {
        $validatedData = $request->validated();

        $slug = Str::slug($validatedData['name']);

        while (Place::where('slug', $slug)->where('id', '!=', $place->id)->exists()) {
            $slug = Str::slug($validatedData['name']) . '-' . Str::random(5);
        }

        $place->update(array_merge($validatedData, ['slug' => $slug]));
        return response()->json(new PlaceResource($place));
    }

    public function destroy(Place $place)
    {
        $place->delete();
        return response()->json(null, 204);
    }
}
