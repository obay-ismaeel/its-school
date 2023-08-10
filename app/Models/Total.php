<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Total extends Model
{
    use HasFactory;

    //protected $appends = ['course_name'];
    protected $hidden = ['created_at', 'updated_at'];

    // public function getCourseNameAttribute()
    // {
    //     return $this->gradeCourse->course()->value('name');
    // }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function gradeCourse()
    {
        return $this->belongsTo(GradeCourse::class, 'grade_course_id');
    }
}
