<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function login(Request $request)
    {
        $request -> validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $teacher = Teacher::firstwhere('username', $request -> username);

        if(! $teacher || ! Hash::check($request -> password, $teacher -> password))
        {
            return response() -> json([
                'status' => false,
                'message' => 'login failed'
            ]);
        }

        return response() -> json([
            'status' => true,
            'message' => 'login success',
            'is_principle' => $teacher->is_principle,
            'token' => $teacher -> createToken('authToken', ['teacher']) -> plainTextToken
        ]);
    }

    public function profile()
    {
        return response() -> json([
            'status' => true,
            'profile' => Auth::user()
        ]);
    }
}
