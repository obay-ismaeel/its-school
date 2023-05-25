<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentStudent extends Model
{
    use HasFactory;

    public function student()
    {
        return $this->belongsTo(student::class, 'student_id');
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignnment_id');
    }
}
