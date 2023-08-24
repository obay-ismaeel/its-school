<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Alerts;
use App\Models\Assignment;
use App\Models\AssignmentStudent;
use App\Models\Attachment;
use App\Models\CalendarItem;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Guardian;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Course;
use App\Models\ExamSchedule;
use App\Models\GradeCourse;
use App\Models\GuardianStudent;
use App\Models\Line;
use App\Models\Mark;
use App\Models\Post;
use App\Models\Report;
use App\Models\Room;
use App\Models\SectionSchedule;
use App\Models\SectionTeacher;
use App\Models\StudentAttendance;
use App\Models\StudentTrip;
use App\Models\Total;
use App\Models\Trip;
use Illuminate\Console\View\Components\Alert;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Grade::factory(10)->create();
        // Course::factory(20)->create();
        // GradeCourse::factory(20)->create();
        // Section::factory(20)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

            // Courses
            Course::factory()->create([
                'name' => 'arabic',
                'image_path' => 'courses/arabic.png'
            ]);
            Course::factory()->create([
                'name' => 'english',
                'image_path' => 'courses/english.png'
            ]);
            Course::factory()->create([
                'name' => 'maths',
                'image_path' => 'courses/maths.png'
            ]);
            Course::factory()->create([
                'name' => 'science',
                'image_path' => 'courses/science.png'
            ]);
            Course::factory()->create([
                'name' => 'geography',
                'image_path' => 'courses/geography.png'
            ]);
            Course::factory()->create([
                'name' => 'french',
                'image_path' => 'courses/french.png'
            ]);
            Course::factory()->create([
                'name' => 'history',
                'image_path' => 'courses/history.png'
            ]);
            Course::factory()->create([
                'name' => 'chemistry',
                'image_path' => 'courses/chemistry.png'
            ]);
            Course::factory()->create([
                'name' => 'philosophy',
                'image_path' => 'courses/philosophy.png'
            ]);
            Course::factory()->create([
                'name' => 'religion',
                'image_path' => 'courses/religion.png'
            ]);

            // Grades
            for($i = 6 ; $i < 12 ; $i++)
            {
                if($i > 9)
                {
                    Grade::factory()->create([
                        'number' => $i,
                        'name' => $i.'th grade',
                ]);
                }
                else
                {
                    Grade::factory()->create([
                        'number' => $i,
                        'name' => $i.'th grade',
                        'type' => 'basic'
                    ]);
                }
            }

            // Sections
            for($i = 1 ; $i <= Grade::count() ; $i++)
            {
                for($j = 1 ; $j < 3 ; $j++)
                {
                    Section::factory()->create([
                        'grade_id' => $i,
                        'number' => $j,
                        'name' => $j.'th section'
                    ]);
                }
            }

            // Course_Grade
            for($i = 1 ; $i <= Grade::count() ; $i++)
            {
                for($j = 1 ; $j <= Course::count() ; $j++)
                {
                    GradeCourse::factory()->create([
                        'grade_id' => $i,
                        'course_id' => $j
                    ]);
                }
            }

            // Students
                for($j = 1 ; $j <= Section::count() ; $j++)
                {
                    Student::factory(10)->create([
                        'section_id' => $j,
                        'grade_id' => Section::find($j)->grade->id
                    ]);
                }

            // Teachers
            for($i = 1 ; $i <= Course::count() ; $i++)
            {
                Teacher::factory()->create([
                    'course_id' => $i,
                    'is_principle' => false
                ]);
            }
            Teacher::factory(5)->create([
                'course_id' => null,
                'is_principle' => true
            ]);

            Teacher::factory()->create([
                'is_principle' => false,
                'username' => 'obayism',
                'password' => '456789',
                'first_name' => 'obay',
                'last_name' => 'ismail',
                'date_of_birth' => fake()->date(),
                'address' => fake()->address(),
                'phone_number' => '0934558769',
                'bio' => fake()->text(),
                'gender' => 'male',
            ]);

            Teacher::factory()->create([
                'is_principle' => true,
                'username' => 'majdham',
                'password' => '123456',
                'first_name' => 'majd',
                'last_name' => 'hammad',
                'date_of_birth' => fake()->date(),
                'address' => fake()->address(),
                'phone_number' => '0934558769',
                'bio' => fake()->text(),
                'gender' => 'male',
            ]);

            // Section Teacher
            for($i = 1 ; $i <= Section::count() ; $i++)
            {
                for($j = 1 ; $j <= Teacher::count() ; $j++)
                {
                    SectionTeacher::factory()->create([
                        'section_id' => $i,
                        'teacher_id' => $j
                    ]);
                }
            }

            // Login multi-auth
                Admin::factory() -> create([
                    'username' => 'majdham',
                    'password' => '123456',
                    'first_name' => 'majd',
                    'last_name' => 'hammad',
                    'phone_number' => '0997311959',
                    'address' => 'Damascus',
                    'gender' => 'male',
                ]);

                Student::factory()->create([
                    'section_id' => 5,
                    'grade_id' => 3,
                    'username' => 'obayism',
                    'password' => '456789',
                    'first_name' => 'obay',
                    'middle_name' => 'hany',
                    'last_name' => 'ismail',
                    'date_of_birth' => fake()->date(),
                    'address' => fake()->address(),
                    'phone_number' => '0934558769',
                    'bio' => fake()->text(),
                    'gender' => fake()->randomElement(['male', 'female']),
                    'type' => fake()->randomElement(['scientific','literary','basic']),
                ]);



                Guardian::factory()->create([
                    'username' => 'obayism',
                    'password' => '456789',
                    'first_name' => 'obay',
                    'last_name' => 'ismail',
                    'phone_number' => '0934558769',
                    'job' => fake()->text(),
                    'gender' => fake()->randomElement(['male', 'female']),
                    'email' => fake()->email(),
                ]);

            // Assignments
            Assignment::factory(20)->create();
            for($i = 13 ; $i <= 18 ; $i++){
                Assignment::factory(3)->create([
                    'section_id' => 5,
                    'grade_course_id' => $i
                ]);
                Assignment::factory(3)->create([
                    'section_id' => 6,
                    'grade_course_id' => $i
                ]);
            }

            // AssignmentStudent
            AssignmentStudent::factory(10)->create([
                'student_id' => 121,
                'is_done' => false
            ]);

            for($i = 1 ; $i <= Section::count() ; $i++)
            {
                $assignments = Assignment::where('section_id', $i)->get();
                $students = Student::where('section_id', $i)->get();
                foreach($students as $student)
                {
                    foreach($assignments as $assignment)
                    {
                        AssignmentStudent::factory()->create([
                            'student_id' => $student->id,
                            'assignment_id' => $assignment->id,
                            'is_done' => false
                        ]);
                    }
                }
            }

            // Posts
            Attachment::factory(30)->create();

            // Marks
            for($i = 21 ; $i <= 30 ; $i++)
            {
                Mark::factory()->create([
                    'student_id' => 121,
                    'grade_course_id' => $i,
                    'type' => 'practical',
                    'term' => 'first'
                ]);
            }

            for($i = 21 ; $i <= 30 ; $i++)
            {
                Mark::factory()->create([
                    'student_id' => 121,
                    'grade_course_id' => $i,
                    'type' => 'exam',
                    'term' => 'first'
                ]);
            }

            for($i = 21 ; $i <= 30 ; $i++)
            {
                Mark::factory()->create([
                    'student_id' => 121,
                    'grade_course_id' => $i,
                    'type' => 'test',
                    'term' => 'first'
                ]);
            }

            for($i = 21 ; $i <= 30 ; $i++)
            {
                Mark::factory()->create([
                    'student_id' => 121,
                    'grade_course_id' => $i,
                    'type' => 'practical',
                    'term' => 'second'
                ]);
            }

            for($i = 21 ; $i <= 30 ; $i++)
            {
                Mark::factory()->create([
                    'student_id' => 121,
                    'grade_course_id' => $i,
                    'type' => 'exam',
                    'term' => 'second'
                ]);
            }

            for($i = 21 ; $i <= 30 ; $i++)
            {
                Mark::factory()->create([
                    'student_id' => 121,
                    'grade_course_id' => $i,
                    'type' => 'test',
                    'term' => 'second'
                ]);
            }
            // Schedule
            $days = ['sunday','monday','tuesday','wednesday','thursday'];
            for($i = 1 ; $i <= Section::count() ; $i++)
            {
                for($j = 0 ; $j < 5 ; $j++)
                {
                    for($k = 1 ; $k < 7 ; $k++)
                    {
                        SectionSchedule::factory()->create([
                            'section_id' => $i,
                            'day' => $days[$j],
                            'order' => $k
                        ]);
                    }
                }
            }

            // Totals
            Total::factory(50)->create();
            for($i = 21 ; $i <= 30 ; $i++)
            {
                Total::factory()->create([
                    'student_id' => 121,
                    'grade_course_id' => $i,
                ]);
            }

            // Students attendance
            StudentAttendance::factory(30)->create();
            StudentAttendance::factory(10)->create(['student_id' => 91]);

            // Reports
            Report::factory(10)->create();

            // Guardian_Student
            GuardianStudent::factory(20)->create();
            GuardianStudent::factory()->create([
                'student_id' => 90,
                'guardian_id' => 1
            ]);
            GuardianStudent::factory()->create([
                'student_id' => 91,
                'guardian_id' => 1
            ]);

            // Exam schedule
            ExamSchedule::factory(20)->create();
            for($i = 13 ; $i < 19 ; $i++){
                ExamSchedule::factory()->create([
                    'grade_course_id' => $i
                ]);
            }

            // Calendar items
            CalendarItem::factory(20)->create();

            // Alerts
            Alerts::factory(20)->create();
            Alerts::factory(10)->create([
                'student_id' => 90
            ]);
            Alerts::factory(10)->create([
                'student_id' => 121
            ]);

            Room::factory(10)->create();

            // Lines
            Line::factory(4)->create();

            // Trips
            for($i=1 ; $i <= Line::count() ; $i++){
                Trip::factory(3)->create([
                    'line_id' => $i
                ]);
            }

            // Students Trips
            StudentTrip::factory(20)->create();
            StudentTrip::factory()->create([
                'student_id' => 91,
                'trip_id' => 1
            ]);

    }
}
