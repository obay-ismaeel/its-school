<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Line;
use Illuminate\Http\Request;

class LineController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'All lines with their trips',
            'lines' =>  Line::with('trips')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $line = Line::create([
            'name' => $request->name
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Line created successfully',
            'line' =>  $line
        ], 201);
    }

    public function destroy(Line $line)
    {
        $line->delete();

        return response()->json([
            'status' => true,
            'message' => 'Line deleted successfully',
            'line' =>  null
        ], 204);
    }
}
