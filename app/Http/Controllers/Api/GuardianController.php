<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\UserNameTrait;
use App\Models\Guardian;

class GuardianController extends Controller
{
    use UserNameTrait;

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
            ], 401);
        }

        return response() -> json([
            'status' => true,
            'message' => 'login success',
            'token' => $guardian -> createToken('authToken', ['guardian']) -> plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->tokens();

        $token->delete();

        return response()->json([
            'status' => true,
            'message' => 'guardian logged out successfully'
        ]);
    }

    public function profile()
    {
        return response() -> json([
            'status' => true,
            'profile' => Auth::user()
        ]);
    }

    public function getChildren()
    {
        return response() -> json([
            'status' => true,
            'message' => 'Parent\'s children',
            'children' => Auth::user()->children
        ]);
    }

    // Admin
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'All guardians ',
            'guardians' => Guardian::all()
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
            'job' => 'required',
            'gender' => 'required',
        ]);

        $attributes['username'] = $this->guardianUserNameGenerate($attributes['first_name'], $attributes['last_name']);

        $attributes['password'] = substr($attributes['first_name'], 0, 2) . mt_rand(10000, 99999) . substr($attributes['last_name'], 0, 2);

        $guardian = Guardian::create($attributes);

        return response()->json([
            'status' => true,
            'message' => 'Guardian has added successfully',
            'guardian' => collect($guardian)->merge(['password' => $attributes['password']])
        ], 201);
    }

    public function update(Request $request, Guardian $guardian)
    {
        $guardian->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Guardian has updated successfully',
            'guardian' => $guardian
        ]);
    }

    public function destroy(Guardian $guardian)
    {
        $guardian->delete();

        return response()->json([
            'status' => true,
            'message' => 'Guardian has deleted successfully',
            'guardian' => null
        ],204);
    }

    public function show(Guardian $guardian)
    {
        return response()->json([
            'status' => true,
            'message' => 'Guardain profile',
            'guardian' => Guardian::with(['children.section', 'children.grade'])->find($guardian->id)
        ]);
    }

}
