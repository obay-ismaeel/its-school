<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssignmentStudent;
use App\Models\GradeCourse;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        // $gradeId = Student::find(Auth::id())->section->grade->id;
        // $gradeCourseId = GradeCourse::where('grade_id', $gradeId)
        //                             ->where('course_id', $courseId)
        //                             ->value('id');

        if(! Auth::user()->section_id){
            $request->validate([
                'student_id' => 'required'
            ]);
        }

        $request->validate([
            'course_id' => 'required'
        ]);

        $sectionId = Student::find($request->student_id ? $request->student_id : Auth::id())->section->id;

        $teacherId = Student::find($request->student_id ? $request->student_id : Auth::id())
                            ->section->teachers()->where('course_id', $request->course_id)->get()->value('id');

        $assignments = Student::find($request->student_id ? $request->student_id : Auth::id())->assignments() //->where('grade_course_id', $gradeCourseId)
                                                ->where('section_id', $sectionId)
                                                ->where('teacher_id', $teacherId)
                                                ->whereHas('assignmentStudent', fn($query) =>
                                                    $query->where('is_done', false)
                                                            ->where('student_id', $request->student_id ? $request->student_id : Auth::id())
                                                )->get();

        return response()->json([
            'status' => true,
            'message' => 'Assignments for a student in specific course',
            'assignments' => $assignments
        ]);
    }

    public function homePageIndex(Request $request)
    {
        if(! Auth::user()->section_id){
            $request->validate([
                'student_id' => 'required'
            ]);
        }

        $sectionId = Student::find($request->student_id ? $request->student_id : Auth::id())->section->id;

        $assignments = Student::find($request->student_id ? $request->student_id : Auth::id())
                                ->assignments()
                                ->where('section_id', $sectionId)
                                ->whereHas('assignmentStudent', fn($query) =>
                                    $query->where('is_done', false)
                                            ->where('student_id', $request->student_id ? $request->student_id : Auth::id())
                                )->orderby('due_date')->get();

        return response()->json([
        'status' => true,
        'message' => 'Assignments for a student ',
        'assignments' => $assignments
        ]);
    }

    public function check($assignmentId)
    {
        AssignmentStudent::where('student_id', Auth::id())
                            ->where('assignment_id', $assignmentId)
                            ->update([
                                'is_done' => true
                            ]);

        return response()->json([
            'status' => true,
            'message' => 'Assignment has checked'
        ]);
    }
}
