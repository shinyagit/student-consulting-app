<?php

namespace App\Http\Requests\Teacher;

use App\Constants\SubjectOptions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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
            'name' => '講師名',
            'department' => '所属学部学科',
            'school_year' => '学年',
            'age' => '年齢',
            'status' => 'ステータス',
            'note' => '備考',
            'available_subjects' => '担当可能科目',
            'available_subjects.*' => '担当可能科目',
        ];
    }
}