<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\GradeCourse;
use Illuminate\Http\Request;

class CourseGradeController extends Controller
{
    public function index($gradeId)
    {
        return response()->json([
            'status' => true,
            'message' => 'Courses for specific grade',
            'courses' => Grade::findOrFail($gradeId)->courses
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'course_id' => 'required|exists:courses,id',
            'description' => 'required',
            'number_of_weekly_classes' => 'required',
            'top_mark' => 'required',
            'lower_mark' => 'required'
        ]);

        $gradeCourse = GradeCourse::create($attributes);

        return response()->json([
            'status' => true,
            'message' => 'Course has added successfully',
            'data' => $gradeCourse
        ], 201);
    }

    public function update(Request $request)
    {
        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $gradeCourse = GradeCourse::where('grade_id', $request->grade_id)
                                    ->where('course_id', $request->course_id)->first();

        $gradeCourse->update([
            'description' => $request->description ? $request->description : $gradeCourse->description,
            'number_of_weekly_classes' => $request->number_of_weekly_classes ? $request->number_of_weekly_classes : $gradeCourse->number_of_weekly_classes,
            'top_mark' => $request->top_mark ? $request->top_mark : $gradeCourse->top_mark,
            'lower_mark' => $request->lower_mark ? $request->lower_mark : $gradeCourse->lower_mark
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Gradecourse has updated successfully',
            'gradecourse' => $gradeCourse
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $gradeCourse = GradeCourse::where('grade_id', $request->grade_id)
                                    ->where('course_id', $request->course_id)->first();

        $gradeCourse->delete();

        return response()->json([
            'status' => true,
            'message' => 'Gradecourse has deleted successfully',
            'gradecourse' => null
        ], 204);
    }
}
