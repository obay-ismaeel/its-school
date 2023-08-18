<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tests\Feature\ExampleTest;

class Grade extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];

    public function students()
    {
        return $this->hasMany(Student::class, 'grade_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'grade_courses');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'grade_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'grade_id');
    }

    public function examSchedule()
    {
        return $this->hasMany(ExamSchedule::class, 'grade_id');
    }

    public function examSchedules()
    {
        return $this->hasManyThrough(ExamSchedule::class ,GradeCourse::class, 'grade_id', 'grade_course_id');
    }

    public function gradeCourses()
    {
        return $this->hasMany(GradeCourse::class, 'grade_id');
    }
}
