<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    function index() {
        $rooms = Room::all();

        $message = 'success';
        if( ! $rooms ) $message = 'There are no rooms to be shown!';

        return response()->json([
            'message' => $message,
            'data' => $rooms
        ]);
    }

    function store(Request $request) {
        $attributes = $request->validate([
            'name' => 'required',
            'capacity' => 'required',
            'location_description' => 'string'
        ]);

        $room = Room::create($attributes);

        return response()->json([
            'message' => 'created successfully',
            'data' => $room
        ]);
    }

    function update(Room $room, Request $request){
        $attributes = $request->validate([
            'name' => 'string',
            'capacity' => 'numeric',
            'location_description' => 'string'
        ]);

        $room->update($attributes);

        return response()->json([
            'message' => 'record updated!',
            'date' => $room
        ]);
    }

    function destroy(Room $room) {
        $room->delete();

        return response()->json([
            'message' => 'record deleted!',
            'data' => $room
        ]);
    }
}
