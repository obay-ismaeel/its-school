<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;

class StudentController extends Controller
{
    public function login(Request $request)
    {
        $request -> validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $student = Student::firstwhere('username', $request -> username);

        if(! $student || ! Hash::check($request -> password, $student -> password))
        {
            return response() -> json([
                'status' => false,
                'message' => 'login failed'
            ]);
        }

        return response() -> json([
            'status' => true,
            'message' => 'login success',
            'token' => $student -> createToken('authToken', ['student']) -> plainTextToken
        ]);
    }

    public function profile()
    {
        return response() -> json([
            'status' => true,
            'message' => 'Student profile',
            'profile' => Auth::user(),
            'section' => Student::find(Auth::id())->section,
            'grade' => Student::find(Auth::id())->section->grade
        ]);
    }

    public function bySection(Section $section) {
        $students = Student::where('section_id', $section->id)->get();
        $students = $students->map( function($student){
            $absence = $student->attendance->where('attended',0)->count();
            return $student->setAttribute('absence', $absence);
         } );
        return response()->json([
            'message'=>'success',
            'data'=> $students
        ]);
    }
}
