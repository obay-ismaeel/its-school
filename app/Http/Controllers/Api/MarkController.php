<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\GradeCourse;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Total;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkController extends Controller
{
    // Students and guardians
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
                                ->totals()->with(['gradeCourse:id,course_id', 'gradeCourse.course:id,name'])
                                ->where('year', $request->year)
                                ->get()
        ]);
    }

    public function getYears(Request $request)
    {
        if(! Auth::user()->section_id){
            $request->validate([
                'student_id' => 'required'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => Total::distinct()->where('student_id', $request->student_id ? $request->student_id : Auth::id())
                            ->get(['year'])
        ]);
    }

    public function getMark(Request $request, Student $student) {
        $attributes = $request->validate([
            'course_id' => 'required',
            'type' => 'required'
        ]);

        $grade_course = GradeCourse::where('grade_id', $student->section->grade->id )
        ->where('course_id', $request['course_id'])
        ->first();

        $current_month = (int)date('m', strtotime(now()));

        $term = $current_month > 8 && $current_month < 2 ? 'first' : 'second';

        $year = $current_month > 8 ? date('Y', strtotime(now()))+1 : date('Y', strtotime(now()));

        $mark = Mark::where([
            ['grade_course_id', $grade_course->id ],
            ['student_id', $student->id ],
            ['type', $attributes['type'] ],
            ['term', $term ],
            ['year', $year ]
        ])->first();

        if(!$mark) $message = 'No score yet!';
        else $message = 'Mark retrieved';

        return response()->json([
            'message' => $message,
            'mark' => $mark->score ?? null
        ]);
    }

    // Teacher
    public function teacherStore(Request $request, Student $student) {

        $request->validate([
            'course_id' => 'required',
            'score' => 'required|numeric|min:0|max:100',
            'type' => 'required'
        ]);

        $grade_course = GradeCourse::where('grade_id', $student->section->grade->id )
        ->where('course_id', $request['course_id'])
        ->first();

        $current_month = (int)date('m', strtotime(now()));

        $term = $current_month > 8 && $current_month < 2 ? 'first' : 'second';

        $year = $current_month > 8 ? date('Y', strtotime(now()))+1 : date('Y', strtotime(now()));

        $mark = Mark::updateOrCreate(
            [
                'student_id'=> $student->id,
                'grade_course_id' => $grade_course->id,
                'type' => $request['type'],
                'term' => $term,
                'year' => $year
            ],
            [ 'score' => $request['score'] ]
        );

        $firstTermScore = Mark::where('student_id', $student->id)
                                ->where('grade_course_id', $grade_course->id)
                                ->where('term', 'first')->avg('score');

        $secondTermScore = Mark::where('student_id', $student->id)
                                ->where('grade_course_id', $grade_course->id)
                                ->where('term', 'second')->avg('score');

        $finalScore = ($firstTermScore + $secondTermScore) / 2;

        Total::updateOrCreate(
            [
                'student_id' => $student->id,
                'grade_course_id' => $grade_course->id,
                'year' => $year
            ],
            [
                'first_term_score' => $firstTermScore ?? 0,
                'second_term_score' => $secondTermScore ?? 0,
                'final_score' => $finalScore,
                'has_failed' => $finalScore < $grade_course->lower_mark ? true : false
            ]
        );

        return response()->json([
            'message' => 'success',
            'data' => $mark
        ]);
    }

    public function getTypes() {
        return response()->json([
            'message' => 'success',
            'data' => ['exam','test','practical']
        ]);
    }

}
