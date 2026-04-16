<?php

namespace App\Http\Requests\Teacher;

use App\Support\SubjectOptions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'teacher_code' => ['required', 'string', 'max:50', 'unique:teachers,teacher_code'],
            'name' => ['required', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'school_year' => ['nullable', 'string', 'max:50'],
            'age' => ['nullable', 'integer', 'min:18', 'max:99'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'note' => ['nullable', 'string'],

            'available_subjects' => ['nullable', 'array'],
            'available_subjects.*' => ['string', Rule::in(SubjectOptions::LIST)],
        ];
    }

    public function attributes(): array
    {
        return [
            'teacher_code' => '講師コード',
            'name' => '講師名',
            'department' => '所属学部学科',
            'school_year' => '学年',
            'age' => '年齢',
            'status' => 'ステータス',
            'note' => '備考',
            'available_subjects' => '担当可能科目',
        ];
    }
}