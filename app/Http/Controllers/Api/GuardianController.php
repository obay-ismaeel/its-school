<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Guardian;

class GuardianController extends Controller
{
    public function login(Request $request)
    {
        $request -> validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $guardian = Guardian::firstwhere('username', $request -> username);

        if(! $guardian || ! Hash::check($request -> password, $guardian -> password))
        {
            return response() -> json([
                'status' => false,
                'message' => 'login failed'
            ]);
        }

        return response() -> json([
            'status' => true,
            'message' => 'login success',
            'token' => $guardian -> createToken('authToken', ['guardian']) -> plainTextToken
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
