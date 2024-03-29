<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentStudent;
use App\Models\Grade;
use App\Models\GradeCourse;
use App\Models\Section;
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

    public function store(Request $request) {
        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'due_date'=>'required',
            'type'=>'required',
            'sections'=>'required',
        ]);

        $teacher = Teacher::find(Auth::user()->id);

        $assignments=[];
        foreach($request['sections'] as $section){
            $grade_course = GradeCourse::where('grade_id', Section::find($section['id'])->grade->id )
            ->where('course_id', $teacher->course->id)
            ->first();

            $assignment = Assignment::create([
                'teacher_id' => $teacher->id,
                'section_id' => $section['id'],
                'grade_course_id' => $grade_course->id,
                'title' => $request['title'],
                'content' => $request['content'],
                'due_date' => $request['due_date'],
                'type' => $request['type']
            ]);

            $assignments[] = $assignment;

            if($students = Student::where('section_id',$section['id'])->get()){
                foreach($students as $student){
                    AssignmentStudent::create([
                        'student_id' => $student->id,
                        'assignment_id' => $assignment->id,
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'success',
            'data' => $assignments
        ]);
    }

    public function bySection(Section $section) {
        $assignments = $section->assignments->orderBy('due');

        return response()->json([
            'message' => 'success',
            'data' => $assignments
        ]);
    }
}
