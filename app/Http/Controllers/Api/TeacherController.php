<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Teacher;
use App\Traits\UserNameTrait;

class TeacherController extends Controller
{
    use UserNameTrait;

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
            ], 401);
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

    // Admin
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'All teachers in the school',
            'teachers' => Teacher::with('course:id,name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'course_id' => 'required_if:is_principle,0',
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date',
            'address' => 'required',
            'phone_number' => 'required',
            'bio' => 'required',
            'image_url' => 'image',
            'gender' => 'required',
            'is_principle' => 'required'
        ]);

        $attributes['username'] = $this->teacherUserNameGenerate($attributes['first_name'], $attributes['last_name']);

        $attributes['password'] = substr($attributes['first_name'], 0, 2) . mt_rand(10000, 99999) . substr($attributes['last_name'], 0, 2);

        if($request->hasFile('image_url'))
        $attributes['image_url'] = $request->file('image_url')->store('students');
        else
        $attributes['image_url'] = 'default_image.png';

        $teacher = Teacher::create($attributes);

        return response()->json([
            'status' => true,
            'message' => 'Teacher has added successfully',
            'teacher' => collect($teacher)->merge(['password' => $attributes['password']])
        ], 201);
    }

    public function update(Request $request, Teacher $teacher)
    {
        $teacher->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Teacher has updated successfully',
            'teacher' => $teacher
        ]);
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return response()->json([
            'status' => true,
            'message' => 'Teacher has deleted successfully',
            'teacher' => null
        ],204);
    }

    public function show(Teacher $teacher)
    {
        return response()->json([
            'status' => true,
            'message' => 'Teacher profile',
            'teacher' => Teacher::with('course')->find($teacher->id)
        ]);
    }

    public function teachersBySection(Section $section)
    {
        return response()->json([
            'status' => true,
            'message' => 'teachers for a section',
            'teachers' => $section->teachers()->where('is_principle', false)->get()
        ]);
    }
}
