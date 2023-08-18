<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'line_id' => 'required|exists:lines,id',
            'name' => 'required',
            'capacity' => 'required|integer'
        ]);

        $trip = Trip::create($attributes);

        return response()->json([
            'status' => true,
            'message' => 'Trip created successfully',
            'trip' =>  $trip
        ], 201);
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();

        return response()->json([
            'status' => true,
            'message' => 'Trip deleted successfully',
            'trip' =>  null
        ], 204);
    }
}
