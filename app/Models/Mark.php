<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function gradeCourse()
    {
        return $this->belongsTo(GradeCourse::class, 'grade_course_id');
    }
}
