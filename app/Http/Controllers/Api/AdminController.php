<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Grade;
use App\Models\Report;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $request -> validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::firstwhere('username', $request -> username);


        if(! $admin || ! Hash::check($request -> password, $admin -> password))
        {
            return response() -> json([
                'status' => false,
                'message' => 'login failed'
            ], 401);
        }

        return response() -> json([
            'status' => true,
            'message' => 'login success',
            'token' => $admin -> createToken('authToken', ['admin']) -> plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->tokens();

        $token->delete();

        return response()->json([
            'status' => true,
            'message' => 'admin logged out successfully'
        ]);
    }

    public function profile()
    {
        return response() -> json([
            'status' => true,
            'profile' => Auth::user()
        ]);
    }

    public function homePage()
    {
        return response()->json([
            'status' => true,
            'students_count' => Student::count(),
            'teachers_count' => Teacher::count(),
            'grades_count' => Grade::count(),
            'sections_count' => Section::count(),
            'reports_count' => Report::count()
        ]);
    }
}
