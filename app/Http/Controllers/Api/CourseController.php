<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GradeCourse;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        if(! Auth::user()->section_id){
            $request->validate([
                'student_id' => 'required'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Courses for specific grade',
            'courses' => Student::find($request->student_id ? $request->student_id : Auth::id())->section->grade->courses
        ]);
    }

    public function show(Request $request, $courseId)
    {
        if(! Auth::user()->section_id){
            $request->validate([
                'student_id' => 'required'
            ]);
        }

        $gradeId = Student::find($request->student_id ? $request->student_id : Auth::id())
                            ->section->grade->id;

        $teacher = Student::find($request->student_id ? $request->student_id : Auth::id())
                            ->section->teachers()->where('course_id', $courseId)->first(['teachers.id', 'first_name', 'last_name']);

        $information = GradeCourse::where('course_id', $courseId)->where('grade_id', $gradeId)->first();
        //$about = collect([$teacher, $information])->all();

        return response()->json([
            'status' => true,
            'message' => 'Information about the course',
            'teacher' => $teacher,
            'about' => $information
        ]);
    }

}
