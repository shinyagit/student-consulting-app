<?php

namespace App\Http\Requests\Student;

use App\Constants\SubjectOptions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'name_kana' => ['nullable', 'string', 'max:255'],
            'school_name' => ['nullable', 'string', 'max:255'],
            'grade' => ['nullable', 'string', 'max:50'],
            'status' => ['required', Rule::in(['active', 'leave', 'graduated', 'withdrawn'])],
            'course_type' => ['nullable', Rule::in(['liberal_arts', 'science', 'undecided'])],

            'exam_subjects' => ['nullable', 'array'],
            'exam_subjects.*' => ['string', Rule::in(SubjectOptions::LIST)],

            'desired_schools' => ['nullable', 'array'],
            'desired_schools.*' => ['nullable', 'string', 'max:255'],

            'note' => ['nullable', 'string'],

            'consultant_user_id' => ['nullable', 'exists:users,id'],

            'teacher_assignments' => ['nullable', 'array'],
            'teacher_assignments.*.teacher_id' => ['nullable', 'exists:teachers,id'],
            'teacher_assignments.*.subjects' => ['nullable', 'array'],
            'teacher_assignments.*.subjects.*' => ['string', Rule::in(SubjectOptions::LIST)],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '生徒氏名',
            'name_kana' => '生徒氏名ふりがな',
            'school_name' => '学校名',
            'grade' => '学年',
            'status' => 'ステータス',
            'course_type' => '文系理系',
            'exam_subjects' => '受験科目',
            'desired_schools' => '志望校',
            'note' => '備考',
            'consultant_user_id' => 'コンサル担当',
            'teacher_assignments' => '担当講師情報',
            'teacher_assignments.*.teacher_id' => '担当講師',
            'teacher_assignments.*.subjects' => '担当科目',
            'teacher_assignments.*.subjects.*' => '担当科目',
        ];
    }
}