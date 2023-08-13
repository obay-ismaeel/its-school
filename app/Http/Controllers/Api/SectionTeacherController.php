<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SectionTeacher;
use Illuminate\Http\Request;

class SectionTeacherController extends Controller
{
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'teacher_id' => 'required|exists:teachers,id'
        ]);

        $check = SectionTeacher::where('section_id', $attributes['section_id'])->where('teacher_id', $attributes['teacher_id']);

        if($check->exists()){
            return response()->json([
                'status' => false,
                'message' => 'Already exist',
            ], 400);
        }

        $data = SectionTeacher::create($attributes);

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data
        ], 201);
    }

    public function destroy(Request $request)
    {
        $attributes = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'teacher_id' => 'required|exists:teachers,id'
        ]);

        $sectionTeacherId = SectionTeacher::where('section_id', $attributes['section_id'])
                        ->where('teacher_id', $attributes['teacher_id'])
                        ->value('id');

        SectionTeacher::findOrFail($sectionTeacherId)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sectionteacher has deleted successfully',
            'sectionteacher' => null
        ], 204);
    }
}
