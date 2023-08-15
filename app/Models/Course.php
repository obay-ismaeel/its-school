<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];

    public function getImagePathAttribute($path)
    {
        return env('APP_URL') .':8000/storage/' . $path;
    }

    public function getNameAttribute($name)
    {
        if(strlen($name) > 10)
            return substr($name, 0, 4);

        return $name;
    }

    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'grade_courses');
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'course_id');
    }
}
