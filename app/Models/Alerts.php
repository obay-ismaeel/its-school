<?php

namespace App\Models;

use Illuminate\Console\View\Components\Alert;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerts extends Model
{
    use HasFactory;

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class, 'teacher_id');
    }
}
