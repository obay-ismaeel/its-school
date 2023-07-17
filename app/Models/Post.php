<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $appends = ['elapsed_time'];
    protected $hidden = ['created_at', 'updated_at'];

    public function getElapsedTimeAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans(now());
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'post_id');
    }
}
