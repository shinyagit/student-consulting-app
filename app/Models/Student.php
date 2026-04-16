<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'name_kana',
        'school_name',
        'grade',
        'status',
        'course_type',
        'exam_subjects',
        'desired_schools',
        'note',
        'consultant_user_id',
    ];

    protected $casts = [
        'exam_subjects' => 'array',
        'desired_schools' => 'array',
    ];

    public function consultant()
    {
        return $this->belongsTo(User::class, 'consultant_user_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class)
            ->withTimestamps();
    }

    public function guidanceRecords()
    {
        return $this->hasMany(GuidanceRecord::class);
    }

    public function studentTeacherSubjects()
    {
        return $this->hasMany(StudentTeacherSubject::class);
    }
}