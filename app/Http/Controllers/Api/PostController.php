<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
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

        //I changed it for testing
        $posts = Post::with(['teacher.course:id,name', 'attachments'])->get();

        // $posts = $posts->where('grade_id', $gradeId);

        return response()->json([
            'status' => true,
            'message' => 'All posts for a grade',
            'posts' => $posts
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'type' => 'required',
            'grade_id' => 'required|exists:grades,id',
            'files' => 'required|array',  // Add validation for the 'files' field
            'files.*' => 'file'
        ]);

        //dd($request);
        $teacher = Teacher::find(Auth::user()->id);

        $post = Post::create([
            'teacher_id' => $teacher->id,
            'grade_id' => $request['grade_id'],
            'title'=>  $request['title'],
            'content' =>   $request['content'],
            'type' => $request['type']
        ]);

        // !!! CORRECT THE TYPE OF THE ATTACHMENT !!!

        foreach($request['files'] as $file){
            error_log('hello');
            Attachment::create([
                'post_id' => $post->id,
                'file_url' => '/storage/' . $file->store('posts'),
                'type' => 'image'
            ]);
        }

        return response()->json([
            'message' => 'success',
            'data' => $post
        ]);
    }

}
