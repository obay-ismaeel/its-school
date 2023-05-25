<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'grade_courses');
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'course_id');
    }
}
