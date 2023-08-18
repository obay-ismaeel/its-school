<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentTrip;
use App\Models\Trip;
use Illuminate\Http\Request;

class StudentTripController extends Controller
{
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'student_id' => 'required|exists:students,id',
            'trip_id' => 'required|exists:trips,id'
        ]);

        if(StudentTrip::where('student_id', $attributes['student_id'])->exists()){
            return response()->json([
                'status' => false,
                'message'=>'Student has already joined a trip'
            ]);
        }

        $tripCapacity = Trip::find($attributes['trip_id'])->capacity;
        $tripStudentsCount = StudentTrip::where('trip_id', $attributes['trip_id'])->count();

        if($tripStudentsCount >= $tripCapacity){
            return response()->json([
                'status' => false,
                'message'=>'This trip is full'
            ]);
        }

        $data = StudentTrip::create($attributes);

        return response()->json([
            'status' => true,
            'message' => 'Student added to trip successfully',
            'student_trip' =>  $data
        ], 201);

    }

}
