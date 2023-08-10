<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherGradesController extends Controller
{
    function index() {
        $teacher = Teacher::find(Auth::user()->id);

        if($teacher->is_principle){
            return response()->json([
                'message' => 'success',
                'data' => Grade::all()->sortBy('number')
            ]);
        }

        $sections = $teacher->sections;

        $grades = $sections->map( function($section){ return $section->grade; } )->unique();

        return response()->json([
            'message' => 'success',
            'data' => $grades
        ]);
    }

    function sections(Grade $grade) {
        if(Teacher::find(Auth::user()->id)->is_principle){
            return response()->json([
                'message' => 'success',
                'data' => Section::orderBy('number')->where('grade_id', $grade->id)->get()
            ]);
        }
        $teacher = Teacher::find(Auth::user()->id);
        $sections = $teacher->sections->where('grade_id', $grade->id)->values();
        return response()->json([
            'message' => 'success',
            'data' => $sections
        ]);
    }
}
