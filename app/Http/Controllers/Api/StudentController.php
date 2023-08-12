<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\GuardianStudent;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Traits\UserNameTrait;
use App\Models\StudentAttendance;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    use UserNameTrait;

    public function login(Request $request)
    {
        $request -> validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $student = Student::firstwhere('username', $request -> username);

        if(! $student || ! Hash::check($request -> password, $student -> password))
        {
            return response() -> json([
                'status' => false,
                'message' => 'login failed'
            ], 401);
        }

        return response() -> json([
            'status' => true,
            'message' => 'login success',
            'token' => $student -> createToken('authToken', ['student']) -> plainTextToken
        ]);
    }

    public function profile()
    {
        return response() -> json([
            'status' => true,
            'message' => 'Student profile',
            'profile' => Auth::user(),
            'section' => Student::find(Auth::id())->section,
            'grade' => Student::find(Auth::id())->grade
        ]);
    }

    //get students by section

    public function bySection(Section $section) {
        $students = Student::where('section_id', $section->id)->get();
        $students = $students->map( function($student){
            $absence = $student->attendance->where('attended',0)->count();
            return $student->setAttribute('absence', $absence);
        } );
        return response()->json([
            'message'=>'success',
            'data'=> $students
        ]);
    }

    // Admin
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'All students in the school',
            'students' => Student::orderBy('section_id')->get()
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'section_id' => 'required|exists:sections,id',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date',
            'address' => 'required',
            'phone_number' => 'required',
            'bio' => 'required',
            'image_url' => 'image',
            'gender' => 'required',
            'type' => 'required',
        ]);

        $request->validate(['guardian_id' => 'required|exists:guardians,id']);

        $attributes['username'] = $this->studentUserNameGenerate($attributes['first_name'], $attributes['last_name']);

        $attributes['password'] = substr($attributes['first_name'], 0, 2) . mt_rand(10000, 99999) . substr($attributes['last_name'], 0, 2);

        if($request->hasFile('image_url'))
        $attributes['image_url'] = $request->file('image_url')->store('students');
        else
        $attributes['image_url'] = 'default_image.png';

        $student = Student::create($attributes);

        GuardianStudent::create([
            'student_id' => $student->id,
            'guardian_id' => $request->guardian_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Student has added successfully',
            'student' => collect($student)->merge(['password' => $attributes['password']])
        ], 201);
    }

    public function update(Request $request, Student $student)
    {
        $student->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Student has updated successfully',
            'student' => $student
        ]);
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json([
            'status' => true,
            'message' => 'Student has deleted successfully',
            'student' => null
        ],204);
    }

    public function show(Student $student)
    {
        $scheduleItems = Student::find($student->id)
        ->section->schedule()->orderBy('order')->get();

        $scheduleItems = $scheduleItems
        ->mapToGroups( fn($scheduleItem) => [$scheduleItem['day'] => $scheduleItem] );

        return response()->json([
            'status' => true,
            'message' => 'Student profile',
            'student' => Student::with(['section', 'grade'])->find($student->id),
            'schedule' => $scheduleItems,
            'attendance' => StudentAttendance::where('student_id', $student->id)
                                                ->where('attended', true)->count(),

            'absence' => StudentAttendance::where('student_id', $student->id)
                                            ->where('attended', false)->count(),

            'first_term_totals' => $student->totals()
                                            ->where('year', now()->year)
                                            ->with(['gradeCourse:id,course_id', 'gradeCourse.course:id,name'])
                                            ->get(['id', 'grade_course_id', 'first_term_score']),

            'second_term_totals' => $student->totals()
                                            ->where('year', now()->year)
                                            ->with(['gradeCourse:id,course_id', 'gradeCourse.course:id,name'])
                                            ->get(['id', 'grade_course_id', 'second_term_score'])

        ]);
    }

    public function studentsBySection(Section $section)
    {
        return response()->json([
            'status' => true,
            'message' => 'students for a section',
            'students' => $section->students
        ]);
    }

    public function studentsByGrade(Grade $grade)
    {
        return response()->json([
            'status' => true,
            'message' => 'students for a grade',
            'students' => $grade->students
        ]);
    }
}
