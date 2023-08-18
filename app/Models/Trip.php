<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    public function line()
    {
        return $this->belongsTo(Trip::class, 'line_id');
    }

    public function studentTrip()
    {
        return $this->hasMany(StudentTrip::class, 'trip_id');
    }
}
