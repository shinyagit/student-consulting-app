<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            [
                'teacher' => [
                    'name' => '田中 一郎',
                    'department' => '広島大学工学部第一類',
                    'school_year' => '3年',
                    'age' => 21,
                    'email' => 'tanaka@example.com',
                    'status' => 'active',
                    'note' => '理系科目担当',
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '物理', '情報'],
            ],
            [
                'teacher' => [
                    'name' => '大西 翔',
                    'department' => '広島大学法学部',
                    'school_year' => '2年',
                    'age' => 20,
                    'email' => 'onishi@example.com',
                    'status' => 'active',
                    'note' => '英語と基礎数学を担当',
                ],
                'subjects' => ['英語', '数学IA', '数学IIBC'],
            ],
            [
                'teacher' => [
                    'name' => '夏 健弘',
                    'department' => '広島大学文学部',
                    'school_year' => '4年',
                    'age' => 22,
                    'email' => 'natsu@example.com',
                    'status' => 'active',
                    'note' => '文系科目担当',
                ],
                'subjects' => ['英語', '国語', '日本史', '世界史', '地理', '倫理', '政治経済', '小論文', '面接'],
            ],
            [
                'teacher' => [
                    'name' => '森上 拓也',
                    'department' => '広島大学総合科学部',
                    'school_year' => '3年',
                    'age' => 21,
                    'email' => 'morigami@example.com',
                    'status' => 'active',
                    'note' => '情報と理科基礎担当',
                ],
                'subjects' => ['情報', '生物基礎', '物理基礎', '化学基礎', '地学基礎'],
            ],
        ];

        foreach ($teachers as $row) {
            $teacher = Teacher::create($row['teacher']);

            $teacher->teacherSubjects()->createMany(
                collect($row['subjects'])
                    ->map(fn ($subject) => ['subject' => $subject])
                    ->all()
            );
        }
    }
}