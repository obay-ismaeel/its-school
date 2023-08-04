<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Post;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if(! Auth::user()->section_id){
            $request->validate([
                'student_id' => 'required'
            ]);
        }

        $gradeId = Student::find($request->student_id ? $request->student_id : Auth::id())->section->grade->id;

        return response()->json([
            'status' => true,
            'message' => 'All posts for a grade',
            'posts' => Post::with(['teacher.course:id,name', 'attachments'])->where('grade_id', $gradeId)->get()
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'type' => 'required',
            'file' => 'file'
        ]);

        $teacher = Teacher::find(Auth::user()->id);

        $post = Post::create([
            'teacher_id' => $teacher->id,
            'grade_id' => $teacher->grade_id,
            'title'=>  $request['title'],
            'content' =>   $request['content'],
            'type' => $request['type']
        ]);

        if($request['file']){   // !!! CORRECT THE TYPE OF THE ATTACHMENT !!!
            $post->attachments->create([
                'file_url' => '/storage/' . $request['file']->store('posts'),
                'type' => 'image'
            ]);
        }

        return response()->json([
            'message' => 'success',
            'data' => $post
        ]);
    }

}
