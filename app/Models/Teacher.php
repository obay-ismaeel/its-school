<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'teacher_id');
    }

    public function attendance()
    {
        return $this->hasMany(TeacherAttendance::class, 'teacher_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'teacher_id');
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_teachers');
    }

    public function gradeCourses()
    {
        return $this->belongsToMany(GradeCourse::class, 'section_teachers');
    }
}
