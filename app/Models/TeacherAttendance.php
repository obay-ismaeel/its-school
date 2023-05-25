<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    use HasFactory;

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
