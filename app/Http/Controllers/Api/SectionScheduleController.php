<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GradeCourse;
use App\Models\Section;
use App\Models\Student;
use App\Models\SectionSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SectionScheduleController extends Controller
{
    public function index(Request $request)
    {
        if(! Auth::user()->section_id){
            $request->validate([
                'student_id' => 'required'
            ]);
        }

        $scheduleItems = Student::find($request->student_id ? $request->student_id : Auth::id())
                                    ->section->schedule()->orderBy('order')->get();

        $scheduleItems = $scheduleItems
                        ->mapToGroups( fn($scheduleItem) => [$scheduleItem['day'] => $scheduleItem] );


        return response()->json([
            'status' => true,
            'message' => 'Schedule for a section',
            'schedule' => $scheduleItems
        ]);
    }

    public function scheduleBySection(Section $section)
    {
        $scheduleItems = $section->schedule()->orderBy('order')->get();

        $scheduleItems = $scheduleItems
        ->mapToGroups( fn($scheduleItem) => [$scheduleItem['day'] => $scheduleItem] );

        return response()->json([
            'status' => true,
            'message' => 'Schedule for a section',
            'schedule' => $scheduleItems
        ]);
    }

    public function autoGenerate()
    {
        if( SectionSchedule::where('section_id', 1)->exists() )
            DB::table('section_schedules')->truncate();

        $days = ['sunday','monday','tuesday','wednesday','thursday'];
        for($i = 1 ; $i <= Section::count() ; $i++)
        {
            if(Section::find($i)->grade->gradeCourses()->sum('number_of_weekly_classes') != 30){
                return response()->json([
                    'status' => false,
                    'message' => "wrong in " . Section::find($i)->grade->name . ": sum of courses classes must be 30"
                ]);
            }
            for($j = 0 ; $j < 5 ; $j++)
            {
                for($k = 1 ; $k < 7 ; $k++)
                {
                    $gradeCourseId = $this->gradeCourseGenerate($i);
                    SectionSchedule::factory()->create([
                        'grade_course_id' => $gradeCourseId,
                        'section_id' => $i,
                        'day' => $days[$j],
                        'order' => $k,
                    ]);
                }
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'schedules generated successfully',
        ]);

    }

    public function gradeCourseGenerate($sectionId)
    {
        $gradeId = Section::find($sectionId)->grade->id;
        $coursesId = Section::find($sectionId)->grade->courses->pluck('id');

        $courseId = $coursesId[ rand(0, count($coursesId) - 1) ];

        $gradeCourseId = GradeCourse::where('course_id', $courseId)
                                    ->where('grade_id', $gradeId)
                                    ->value('id');

        $numberOfClasses = GradeCourse::where('course_id', $courseId)
                                        ->where('grade_id', $gradeId)
                                        ->value('number_of_weekly_classes');

        $count = SectionSchedule::where('section_id', $sectionId)->where('grade_course_id', $gradeCourseId)->count();

        if( $count >= $numberOfClasses )
            return $this->gradeCourseGenerate($sectionId);

            return $gradeCourseId;

    }

}
