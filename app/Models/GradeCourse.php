<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeCourse extends Model
{
    use HasFactory;

    public function grade()
    {
        return $this->belongsTo(Grade::class,'grade_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'grade_course_id');
    }

    public function schedule()
    {
        return $this->hasMany(SectionSchedule::class, 'grade_course_id');
    }

    public function examSchedule()
    {
        return $this->hasMany(ExamSchedule::class, 'grade_course_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'section_teachers');
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_teachers');
    }

    public function marks()
    {
        return $this->hasMany(GradeCourse::class, 'garde_course_id');
    }
}
