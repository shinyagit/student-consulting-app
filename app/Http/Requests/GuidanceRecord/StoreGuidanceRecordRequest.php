<?php

namespace App\Http\Requests\GuidanceRecord;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuidanceRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'exists:students,id'],
            'consulted_at' => ['required', 'date'],
            'growth_point' => ['nullable', 'string'],
            'challenge_point' => ['nullable', 'string'],
            'self_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'note' => ['nullable', 'string'],
            'next_plan_date' => ['nullable', 'date'],
            'subject1_name' => ['nullable', 'string', 'max:255'],
            'subject1_detail' => ['nullable', 'string'],
            'subject2_name' => ['nullable', 'string', 'max:255'],
            'subject2_detail' => ['nullable', 'string'],
            'subject3_name' => ['nullable', 'string', 'max:255'],
            'subject3_detail' => ['nullable', 'string'],
            'other_plan' => ['nullable', 'string'],
        ];
    }
}