<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function attendanceDayCount()
    {
        return response()->json([
            'status' => true,
            'message' => 'Number of attendance and absence days',
            'attendance' => StudentAttendance::where('student_id', Auth::id())->where('attended', true)->count(),
            'absence' => StudentAttendance::where('student_id', Auth::id())->where('attended', false)->count()
        ]);
    }
}
