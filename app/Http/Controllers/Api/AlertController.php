<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alerts;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use Illuminate\Http\Request;

class AlertController extends Controller
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
            'message' => 'show all alerts',
            'alerts' => Student::find($request->student_id ? $request->student_id : Auth::id())->alerts
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'student_id' => 'required|exists:students,id',
            'title' => 'required',
            'content' => 'required'
        ]);

        if( $request->user()->tokenCan('teacher') ){

            $attributes['teacher_id'] = Auth::id();
            $alert = Alerts::create($attributes);
        }

        else{
                $alert = Alerts::create($attributes);
            }

        return response()->json([
            'status' => true,
            'message' => 'Alert has added successfully',
            'alert' => $alert
        ], 201);

    }
}
