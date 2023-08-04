<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'All grades with their sections and students',
            'grades'  =>   Grade::with(['sections' => ['students:id,section_id,first_name,last_name'] ])
                                ->withCount(['sections', 'students', 'courses'])
                                ->get()
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'number' => 'required',
            'name' => 'required',
            'type' => 'required'
        ]);

        $grade = Grade::create($attributes);

        return response()->json([
            'status' => true,
            'message' => 'Grade has added successfully',
            'grade' => $grade
        ], 201);
    }

    public function update(Request $request, Grade $grade)
    {
        $grade->update([
            'number' => $request->number ? $request->number : $grade->number,
            'name' => $request->name ? $request->name : $grade->name,
            'type' => $request->type ? $request->type : $grade->type
        ]);

        return response()->json([
            'status' => true,
            'message' => 'grade has updated successfully',
            'grade' => $grade
        ]);
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return response()->json([
            'status' => true,
            'message' => 'grade has deleted successfully',
            'grade' => null
        ], 204);
    }

    public function teacherIndex(Section $section){
        $teacher = Teacher::find(Auth::user()->id);

        $courses = $teacher->is_principle ? $section->grade->courses : $teacher->course;

        return response()->json([
            'message' => 'success',
            'data' => $courses
        ]);
    }

}
