<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'title' => 'required',
            'content' => 'required'
        ]);

        $report = Report::create([
            'guardian_id' => Auth::id(),
            'student_id' => $request->student_id,
            'title' => $request->title,
            'content' => $request->content
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Report has added successfully',
            'report' => $report
        ], 201);
    }
}
