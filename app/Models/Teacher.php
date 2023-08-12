<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $hidden = [
        'password',
    ];

    public function getImageUrlAttribute($path)
    {
        if(! filter_var($path, FILTER_VALIDATE_URL))
        return env('APP_URL') .':8000/storage/' . $path;

        return $path;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'teacher_id');
    }

    public function attendance()
    {
        return $this->hasMany(TeacherAttendance::class, 'teacher_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'teacher_id');
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_teachers');
    }

    public function gradeCourses()
    {
        return $this->belongsToMany(GradeCourse::class, 'section_teachers');
    }
}
