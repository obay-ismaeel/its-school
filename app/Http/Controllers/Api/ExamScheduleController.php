<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExamSchedule;
use App\Models\GradeCourse;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ExamScheduleController extends Controller
{
    public function index(Request $request)
    {
        if(! Auth::user()->section_id){
            $request->validate([
                'student_id' => 'required'
            ]);
        }

        $student = Student::findOrFail($request->student_id ? $request->student_id : Auth::id());

        $gradeCourseIds = GradeCourse::where('grade_id', $student->grade->id)->pluck('id');

        $examSchedule = ExamSchedule:://with(['gradeCourse:id,course_id', 'gradeCourse.course:id,name'])
                    whereIn('grade_course_id', $gradeCourseIds)
                    ->get();

        foreach($examSchedule as $value){
            $courseName = GradeCourse::find($value->grade_course_id)->course->name;
            $value->setAttribute('course_name', $courseName);
        }

        return response()->json([
            'status' => true,
            'message' => 'Exam schedule',
            'data' => $examSchedule
        ]);

    }
}
