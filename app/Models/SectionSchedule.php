<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionSchedule extends Model
{
    use HasFactory;

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function gradeCourse()
    {
        return $this->belongsTo(GradeCourse::class, 'grade_course_id');
    }
}
