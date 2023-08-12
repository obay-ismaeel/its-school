<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'number' => 'required',
            'name' => 'required'
        ]);

        $section = Section::create($attributes);

        return response()->json([
            'status' => true,
            'message' => 'section has added successfully',
            'section' => $section
        ], 201);
    }

    public function update(Request $request, Section $section)
    {
        $section->update([
            'number' => $request->number ? $request->number : $section->number,
            'name' => $request->name ? $request->name : $section->name,
            'grade_id' => $request->grade_id ? $request->grade_id : $section->grade_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'section has updated successfully',
            'section' => $section
        ]);
    }

    public function destroy(Section $section)
    {
        $section->delete();

        return response()->json([
            'status' => true,
            'message' => 'section has deleted successfully',
            'section' => null
        ], 204);
    }

    public function sectionsByGrade(Grade $grade)
    {
        return response()->json([
            'status' => true,
            'message' => 'sections for a grade',
            'sections' => $grade->sections()->withCount('students')->get()
        ]);
    }
}
