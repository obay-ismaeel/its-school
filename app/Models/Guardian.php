<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    public function children()
    {
        return $this->belongsToMany(Student::class, 'guardian_students');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'guardian_id');
    }
}
