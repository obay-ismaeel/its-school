<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionSchedule extends Model
{
    use HasFactory;

    protected $appends = ['course_name'];
    protected $hidden = ['created_at', 'updated_at'];

    public function getCourseNameAttribute()
    {
        return $this->gradeCourse->course()->value('name');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function gradeCourse()
    {
        return $this->belongsTo(GradeCourse::class, 'grade_course_id');
    }
}
