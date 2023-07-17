<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GradeCourse;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function studentIndex()
    {
        return response()->json([
            'status' => true,
            'message' => 'Courses for specific grade',
            'courses' => Student::find(Auth::id())->section->grade->courses
        ]);
    }

    public function show(Request $request)
    {
        $request->validate([
            'course_id' => 'required'
        ]);

        $gradeId = Student::find(Auth::id())->section->grade->id;
        $teacher = Student::find(Auth::id())->section->teachers()->where('course_id', $request->course_id)->first();
        $information = GradeCourse::where('course_id', $request->course_id)->where('grade_id', $gradeId)->first();
        //$about = collect([$teacher, $information])->all();

        return response()->json([
            'status' => true,
            'message' => 'Information about the course',
            'teacher' => $teacher,
            'about' => $information
        ]);
    }
}
