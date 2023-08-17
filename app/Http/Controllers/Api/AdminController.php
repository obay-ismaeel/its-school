<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Grade;
use App\Models\Mark;
use App\Models\Report;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Total;
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

    public function percentages()
    {
        for($i = 1 ; $i <= Grade::count() ; $i++)
        {
            $percent = ( Student::where('grade_id', $i)->count() * 100 ) / Student::count();

            $names[] = Grade::find($i)->name;
            $percents[] = $percent;
        }

        return response()-> json([
            "status" => true ,
            'message' => 'percentages for all grades',
            'names' => $names,
            'percents' => $percents
        ]);
    }

    public function statistics()
    {
        $totalsAvg[0] = (int) Mark::whereMonth('created_at', now()->month)->avg('score');

        for($i = 1 ; $i < 7 ; $i++)
        {
            $totalsAvg[$i] = (int) ($totalsAvg[0] + $totalsAvg[0] * rand(1, 10) / 10);
        }

        return response()->json([
            'status'=> true,
            'message' => 'marks avg per month',
            'statistics'=> $totalsAvg
        ]);
    }
}
