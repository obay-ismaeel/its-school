<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherSchedule extends Controller
{
    function index(Request $request) {
        $request->validate([
            'day' => 'required'
        ]);

        $teacher = Teacher::find(Auth::user()->id);
        $name = $teacher->course->name;
        $sections = $teacher->sections;
        $schedules = $sections->map( fn($section)=>$section->schedule );
        $response = [];
        for ($i=0; $i < sizeof($schedules); $i++) {
            for ($j=0; $j < sizeof($schedules[$i]); $j++) {
                if($schedules[$i][$j]['course_name']==$name){
                    $response[] = $schedules[$i][$j];
                }
            }
        }
        $response = collect($response);
        $response = $response->mapToGroups(function($res){ return [$res['day'] => $res]; });
        // $response = $response->sortBy('order');
        $response = $response->toArray();

        $response = $response[$request['day']];

        return response()->json([
            'data' => $response
        ]);
    }
}
