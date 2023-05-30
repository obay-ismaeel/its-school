<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $attributes = $request -> validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::firstwhere('username', $request -> username);


        if(! $admin || ! Hash::check($request -> password, $admin -> password))
        {
            return response() -> json([
                'status' => false,
                'message' => 'login failed'
            ]);
        }

        return response() -> json([
            'status' => true,
            'message' => 'login success',
            'token' => $admin -> createToken('authToken', ['admin']) -> plainTextToken
        ]);
    }

    public function details()
    {
        return response() -> json([
            'status' => true,
            'message' => Auth::user()
        ]);
    }
}
