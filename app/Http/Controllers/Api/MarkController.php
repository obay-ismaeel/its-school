<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GradeCourse;
use App\Models\Mark;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkController extends Controller
{
    public function index(Request $request)
    {
        if(! Auth::user()->section_id){
            $request->validate([
                'student_id' => 'required'
            ]);
        }

        $request->validate([
            'course_id' => 'required',
            'year' => 'required'
        ]);

        $gradeId = Student::find($request->student_id ? $request->student_id : Auth::id())->section->grade->id;

        $gradeCourseId = GradeCourse::where('course_id', $request->course_id)->where('grade_id', $gradeId)->value('id');

        return response()->json([
            'status' => true,
            'message' => 'Student\'s marks in specific course',

            'first_term' => Mark::where('student_id', $request->student_id ? $request->student_id : Auth::id())
                                ->where('grade_course_id', $gradeCourseId)
                                ->where('term', 'first')
                                ->where('year', $request->year)
                                ->get(),

            'second_term' => Mark::where('student_id', $request->student_id ? $request->student_id : Auth::id())
                                ->where('grade_course_id', $gradeCourseId)
                                ->where('term', 'second')
                                ->where('year', $request->year)
                                ->get()
        ]);
    }

    public function total(Request $request)
    {
        if(! Auth::user()->section_id){
            $request->validate([
                'student_id' => 'required'
            ]);
        }

        $request->validate([
            'year' => 'required'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Totals for a student',
            'totals' => Student::find($request->student_id ? $request->student_id : Auth::id())
                                ->totals()->where('year', $request->year)->get()
        ]);
    }

}
