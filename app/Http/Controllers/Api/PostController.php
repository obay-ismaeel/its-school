<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PostController extends Controller
{
    public function studentIndex()
    {
        $gradeId = Student::find(Auth::id())->section->grade->id;

        return response()->json([
            'status' => true,
            'message' => 'All posts for a grade',
            'posts' => Post::with(['teacher.course:id,name', 'attachments'])->where('grade_id', $gradeId)->get()
        ]);
    }
}
