<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuidanceRecord extends Model
{
    protected $fillable = [
        'student_id',
        'user_id',
        'consulted_at',
        'growth_point',
        'challenge_point',
        'self_score',
        'note',
        'next_plan_date',
        'subject1_name',
        'subject1_detail',
        'subject2_name',
        'subject2_detail',
        'subject3_name',
        'subject3_detail',
        'other_plan',
    ];

    protected function casts(): array
    {
        return [
            'consulted_at' => 'datetime',
            'next_plan_date' => 'datetime',
            'self_score' => 'integer',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}