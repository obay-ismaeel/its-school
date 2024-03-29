<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Grade;
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

        $posts = Post::where('grade_id', $gradeId)
        ->with(['teacher.course:id,name', 'attachments'])->latest()->get();

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
            'files.*' => 'image'
        ]);

        $teacher = Teacher::find(Auth::user()->id);

        $post = Post::create([
            'teacher_id' => $teacher->id,
            'grade_id' => $request['grade_id'],
            'title'=>  $request['title'],
            'content' =>   $request['content'],
            'type' => $request['type']
        ]);

        if($request['files']){
            foreach($request['files'] as $file){
                Attachment::create([
                    'post_id' => $post->id,
                    'file_url' => $file->store('posts'),
                    'type' => 'image'
                ]);
            }
        }

        return response()->json([
            'message' => 'success',
            'data' => $post
        ]);
    }

    public function byGrade(Grade $grade){
        $posts = $grade->posts->sortByDesc('created_at')->load(['teacher.course', 'attachments']);

        return response()->json([
            'message' => 'success',
            'data' => $posts->values()
        ]);
    }

    function destroy(Post $post) {
        if( ! Auth::user()->is_principle && $post['teacher_id'] != Auth::id() )
            return response()->json([ 'message' => 'it is not your post fool' ], 401);

        $post->delete();

        return response()->json([
            'message' => 'deleted successfully!',
        ]);
    }

}
