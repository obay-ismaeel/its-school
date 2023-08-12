<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\GradeCourse;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // Students and guardians
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

    public function show(Request $request)
    {
        if(! Auth::user()->section_id){
            $request->validate([
                'student_id' => 'required'
            ]);
        }

        $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);

        $gradeId = Student::find($request->student_id ? $request->student_id : Auth::id())
                            ->section->grade->id;

        $teacher = Student::find($request->student_id ? $request->student_id : Auth::id())
                            ->section->teachers()->where('course_id', $request->course_id)->first(['teachers.id', 'first_name', 'last_name']);

        $information = GradeCourse::where('course_id', $request->course_id)->where('grade_id', $gradeId)->first();
        //$about = collect([$teacher, $information])->all();

        return response()->json([
            'status' => true,
            'message' => 'Information about the course',
            'teacher' => $teacher,
            'about' => $information
        ]);
    }

    // Admins
    public function webIndex()
    {
        return response()->json([
            'status' => true,
            'message' => 'All courses in the school',
            'courses' => Course::all()
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|unique:courses,name',
            'description' => 'required',
            'image_path' => 'required|image'
        ]);

        $attributes['image_path'] = $request->file('image_path')->store('courses');

        $course = Course::create($attributes);

        return response()->json([
            'status' => true,
            'message' => 'Course has added successfully',
            'course' => $course
        ], 201);
    }

    public function update(Request $request, Course $course)
    {
        $course->update([
            'name' => $request->name ? $request->name : $course->name,
            'description' => $request->description ? $request->description : $course->description
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Course has updated successfully',
            'course' => $course
        ]);
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([
            'status' => true,
            'message' => 'Course has deleted successfully',
            'course' => null
        ], 204);
    }

}
