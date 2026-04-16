<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        // if (app()->environment('production')) {
        //     throw new \RuntimeException(static::class . ' cannot run in production.');
        // }

        $teachers = [
            [
                'teacher' => [
                    'teacher_code' => 'T001',
                    'name' => '田中一郎',
                    'department' => '広島大学工学部第一類',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => '理系科目担当',
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '物理', '情報'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T002',
                    'name' => '大西翔',
                    'department' => '広島大学法学部',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => '英語と基礎数学を担当',
                ],
                'subjects' => ['英語', '数学IA', '数学IIBC'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T003',
                    'name' => '夏健弘',
                    'department' => '広島大学文学部',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => '文系科目担当',
                ],
                'subjects' => ['英語', '国語', '日本史', '世界史', '地理', '倫理', '政治経済', '小論文', '面接'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T004',
                    'name' => '森上拓也',
                    'department' => '広島大学総合科学部',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => '情報と理科基礎担当',
                ],
                'subjects' => ['情報', '生物基礎', '物理基礎', '化学基礎', '地学基礎'],
            ],
        ];

        foreach ($teachers as $row) {
            $teacherData = $row['teacher'];

            $teacherData['name'] = preg_replace('/[\p{Z}\s]+/u', '', $teacherData['name']);
            $teacherData['department'] = filled($teacherData['department'] ?? null)
                ? preg_replace('/[\p{Z}\s]+/u', '', $teacherData['department'])
                : null;

            $teacher = Teacher::updateOrCreate(
                ['teacher_code' => $teacherData['teacher_code']],
                $teacherData
            );

            $teacher->teacherSubjects()->delete();

            if (! empty($row['subjects'])) {
                $teacher->teacherSubjects()->createMany(
                    collect($row['subjects'])
                        ->filter(fn ($subject) => filled($subject))
                        ->map(fn ($subject) => trim($subject))
                        ->filter(fn ($subject) => $subject !== '')
                        ->unique()
                        ->values()
                        ->map(fn ($subject) => ['subject' => $subject])
                        ->all()
                );
            }
        }
    }
}