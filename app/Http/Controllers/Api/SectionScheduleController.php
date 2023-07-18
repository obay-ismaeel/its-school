<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionScheduleController extends Controller
{
    public function index(Request $request)
    {
        if(! Auth::user()->section_id){
            $request->validate([
                'student_id' => 'required'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Schedule for a section',
            'schedule' => Student::find($request->student_id ? $request->student_id : Auth::id())
                                    ->section->schedule()->orderby('order')->get()
        ]);
    }

}
