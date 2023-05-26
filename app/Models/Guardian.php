<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Guardian extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $hidden = [
        'password'
    ];

    public function children()
    {
        return $this->belongsToMany(Student::class, 'guardian_students');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'guardian_id');
    }
}
