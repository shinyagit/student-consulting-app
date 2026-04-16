<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    protected $fillable = [
        'teacher_id',
        'subject',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}