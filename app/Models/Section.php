<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    public function students()
    {
        return $this->hasMany(Student::class, 'section_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'section_id');
    }

    public function schedule()
    {
        return $this->hasMany(SectionSchedule::class, 'section_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'section_teachers');
    }

    public function gradeCourses()
    {
        return $this->belongsToMany(GradeCourse::class, 'section_teachers');
    }
}
