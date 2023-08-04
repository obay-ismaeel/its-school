<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function attendanceCount(Request $request)
    {
        if(! Auth::user()->section_id){
            $request->validate([
                'student_id' => 'required'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Number of attendance and absence days',
            'attendance' => StudentAttendance::where('student_id', $request->student_id ? $request->student_id : Auth::id())
                                                ->where('attended', true)->count(),

            'absence' => StudentAttendance::where('student_id', $request->student_id ? $request->student_id : Auth::id())
                                            ->where('attended', false)->count()
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'students' => 'required'
        ]);

        foreach ($request['students'] as  $value ) {
            $student = StudentAttendance::firstOrNew([
                'student_id' => $value['id'],
                'date' => date('Y-m-d', strtotime(now())),
            ]);
            $student->update(['attended'=>$value['attended']]);
            $student->save();
        }

        return response()->json([
            'message' => 'updated attendance!',
        ]);
    }

}
