<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCard extends Model
{
    use HasFactory;

    public function student() {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function room(){
        return $this->belongsTo(Room::class, 'room_id');
    }
}
