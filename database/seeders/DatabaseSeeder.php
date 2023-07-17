<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Assignment;
use App\Models\AssignmentStudent;
use App\Models\Attachment;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Guardian;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Course;
use App\Models\GradeCourse;
use App\Models\Mark;
use App\Models\Post;
use App\Models\SectionSchedule;
use App\Models\SectionTeacher;
use App\Models\Total;

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
            Course::factory(6)->create();

            // Grades
            for($i = 9 ; $i < 12 ; $i++)
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
                    Student::factory(15)->create([
                        'section_id' => $j,
                    ]);
                }

            // Teachers
            for($i = 1 ; $i <= Course::count() ; $i++)
            {
                Teacher::factory()->create([
                    'course_id' => $i
                ]);
            }

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
                    'password' => bcrypt(123456),
                    'first_name' => 'majd',
                    'last_name' => 'hammad',
                    'phone_number' => '0997311959',
                    'address' => 'Damascus',
                    'gender' => 'male',
                ]);

                Student::factory()->create([
                    'section_id' => 5,
                    'username' => 'obayism',
                    'password' => bcrypt(456789),
                    'first_name' => 'obay',
                    'middle_name' => 'hany',
                    'last_name' => 'ismail',
                    'date_of_birth' => fake()->date(),
                    'address' => fake()->address(),
                    'phone_number' => fake()->phoneNumber(),
                    'bio' => fake()->text(),
                    'gender' => fake()->randomElement(['male', 'female']),
                    'type' => fake()->randomElement(['scientific','literary','basic']),
                ]);

                Teacher::factory()->create([
                    'username' => 'obayism',
                    'password' => bcrypt(456789),
                    'first_name' => 'obay',
                    'last_name' => 'ismail',
                    'date_of_birth' => fake()->date(),
                    'address' => fake()->address(),
                    'phone_number' => fake()->phoneNumber(),
                    'bio' => fake()->text(),
                    'gender' => fake()->randomElement(['male', 'female']),
                    'image_url' => fake()->url(),
                ]);

                Guardian::factory()->create([
                    'username' => 'obayism',
                    'password' => bcrypt(456789),
                    'first_name' => 'obay',
                    'last_name' => 'ismail',
                    'phone_number' => fake()->phoneNumber(),
                    'job' => fake()->text(),
                    'gender' => fake()->randomElement(['male', 'female']),
                    'email' => fake()->email(),
                ]);

            // Assignments
            Assignment::factory(20)->create();

            // AssignmentStudent
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
                            'assignment_id' => $assignment->id
                        ]);
                    }
                }
            }

            // Posts
            Attachment::factory(30)->create();

            // Marks
            for($i = 13 ; $i < 19 ; $i++)
            {
                Mark::factory()->create([
                    'student_id' => 91,
                    'grade_course_id' => $i,
                ]);
            }

            // Schedule
            $days = ['sunday','monday','tuesday','wednesday','thursday'];
            for($i = 1 ; $i < Section::count() ; $i++)
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
            for($i = 13 ; $i < 19 ; $i++)
            {
                Total::factory()->create([
                    'student_id' => 91,
                    'grade_course_id' => $i,
                ]);
            }

    }
}
