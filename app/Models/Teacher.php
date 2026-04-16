<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'teacher_code',
        'name',
        'department',
        'school_year',
        'age',
        'status',
        'note',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class)
            ->withTimestamps();
    }

    public function teacherSubjects()
    {
        return $this->hasMany(TeacherSubject::class);
    }

    public function studentTeacherSubjects()
    {
        return $this->hasMany(StudentTeacherSubject::class);
    }
}