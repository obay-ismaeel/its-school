<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Grade;
use App\Models\GradeCourse;
use App\Models\Section;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Grade::factory(10)->create();
        Course::factory(20)->create();
        GradeCourse::factory(20)->create();
        Section::factory(20)->create();

        Admin::factory(5)->create();
    }
}
