<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionScheduleController extends Controller
{
    public function studentIndex()
    {
        return response()->json([
            'status' => true,
            'message' => 'Schedule for a section',
            'schedule' => Student::find(Auth::id())->section->schedule()->orderby('order')->get()
        ]);
    }
}
