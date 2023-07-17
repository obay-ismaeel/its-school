<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function gradeCourse()
    {
        return $this->belongsTo(GradeCourse::class, 'grade_course_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'assignment_students');
    }

    public function assignmentStudent()
    {
        return $this->hasMany(AssignmentStudent::class, 'assignment_id');
    }
}
