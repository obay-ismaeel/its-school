<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tests\Feature\ExampleTest;

class Grade extends Model
{
    use HasFactory;

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
}
