<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExamCard;
use App\Models\Room;
use App\Models\Student;
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

    function generate() {
        $grades = Student::all()->groupBy('grade_id');

        $maxGradeCount = $grades->map(function($grade){ return $grade->count(); })->max();

        $rooms = Room::all();

        $maxRoomsCapacity = $rooms->sum('capacity');

        if( $maxGradeCount > $maxRoomsCapacity )
            return response()->json(['message'=>'The Rooms Capacity is not enough!', 'needed'=>$maxGradeCount-$maxRoomsCapacity]);

        if( ExamCard::all()->isNotEmpty() ) ExamCard::truncate();

        $roomIndex = 0; $filled = 0; $num = 0;

        foreach($grades as $grade){
            foreach($grade as $student){
                if( $filled > $rooms[$roomIndex]['capacity'] ){ //check if current room is full
                    $roomIndex++;
                    $filled = 0;
                }

                $gradeNum = $student->grade->number;

                ExamCard::create([
                    'student_id' => $student->id,
                    'room_id' => $rooms[$roomIndex]->id,
                    'number' => ( $gradeNum >= 10 ? $gradeNum : '0' . $gradeNum ). '0' . str_pad($num++, 3, '0', STR_PAD_LEFT)
                ]);

                $filled++;
            }

            $roomIndex = 0; $num = 0; $filled = 0;
        }

        return response()->json(['message' => 'Students are Assigned to Rooms Successfully!']);
    }
}
