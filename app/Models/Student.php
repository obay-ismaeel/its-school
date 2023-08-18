<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getImageUrlAttribute($path)
    {
        if(! filter_var($path, FILTER_VALIDATE_URL))
            return env('DOMAIN') .'/storage/' . $path;

        return $path;
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function guardians()
    {
        return $this->belongsToMany(Guardian::class,'guardian_students');
    }

    public function attendance()
    {
        return $this->hasMany(StudentAttendance::class, 'student_id');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class, 'student_id');
    }

    public function totals()
    {
        return $this->hasMany(Total::class, 'student_id');
    }

    public function alerts()
    {
        return $this->hasMany(Alerts::class, 'student_id');
    }

    public function guardiansReports()
    {
        return $this->hasMany(Report::class, 'guardian_id');
    }

    public function assignments()
    {
        return $this->belongsToMany(Assignment::class, 'assignment_students');
    }

    public function studentTrip()
    {
        return $this-> hasOne(StudentTrip::class, 'student_id');
    }

    public function card() {
        return $this->hasOne(ExamCard::class, 'student_id');
    }

}
