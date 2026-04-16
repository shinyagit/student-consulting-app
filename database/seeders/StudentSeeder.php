<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\StudentTeacherSubject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            throw new \RuntimeException(static::class.' cannot run in production.');
        }
        
        $teachers = Teacher::with('teacherSubjects')->get();
        $consultantUsers = User::whereIn('role', ['admin', 'staff'])
            ->orderBy('id')
            ->get();

        $students = [
            [
                'student' => [
                    'name' => '山田 太郎',
                    'name_kana' => 'ヤマダ タロウ',
                    'school_name' => '広島第一高校',
                    'grade' => '高1',
                    'status' => 'active',
                    'course_type' => 'science',
                    'exam_subjects' => ['英語', '数学IA', '数学IIBC', '化学', '物理', '情報'],
                    'desired_schools' => ['広島大学工学部', '岡山大学工学部'],
                    'note' => '理系型。数学と物理を重点管理。',
                ],
                'assignments' => [
                    [
                        'teacher_index' => 0,
                        'subjects' => ['数学IA', '数学IIBC', '物理'],
                    ],
                    [
                        'teacher_index' => 1,
                        'subjects' => ['英語'],
                    ],
                ],
            ],
            [
                'student' => [
                    'name' => '中村 陸',
                    'name_kana' => 'ナカムラ リク',
                    'school_name' => '広島西高校',
                    'grade' => '高2',
                    'status' => 'leave',
                    'course_type' => 'science',
                    'exam_subjects' => ['英語', '数学IA', '数学IIBC', '数学III', '化学', '物理'],
                    'desired_schools' => ['広島大学情報科学部', '九州大学工学部'],
                    'note' => '現在休会中。復帰後は数学IIIを優先。',
                ],
                'assignments' => [
                    [
                        'teacher_index' => 0,
                        'subjects' => ['数学III', '物理'],
                    ],
                ],
            ],
            [
                'student' => [
                    'name' => '佐藤 花',
                    'name_kana' => 'サトウ ハナ',
                    'school_name' => '広島中央高校',
                    'grade' => '高3',
                    'status' => 'active',
                    'course_type' => 'liberal_arts',
                    'exam_subjects' => ['英語', '国語', '日本史', '小論文', '面接'],
                    'desired_schools' => ['広島大学法学部', '岡山大学法学部'],
                    'note' => '記述と小論文を強化中。',
                ],
                'assignments' => [
                    [
                        'teacher_index' => 2,
                        'subjects' => ['英語', '国語', '小論文'],
                    ],
                ],
            ],
            [
                'student' => [
                    'name' => '松本 翔',
                    'name_kana' => 'マツモト ショウ',
                    'school_name' => '安古市高校',
                    'grade' => '高2',
                    'status' => 'active',
                    'course_type' => 'liberal_arts',
                    'exam_subjects' => ['英語', '国語', '世界史', '政治経済', '情報'],
                    'desired_schools' => ['広島大学経済学部', '神戸大学経済学部'],
                    'note' => '社会2科目の整理が必要。',
                ],
                'assignments' => [
                    [
                        'teacher_index' => 2,
                        'subjects' => ['英語', '世界史', '政治経済'],
                    ],
                    [
                        'teacher_index' => 3,
                        'subjects' => ['情報'],
                    ],
                ],
            ],
            [
                'student' => [
                    'name' => '井上 葵',
                    'name_kana' => 'イノウエ アオイ',
                    'school_name' => '舟入高校',
                    'grade' => '高1',
                    'status' => 'active',
                    'course_type' => 'undecided',
                    'exam_subjects' => ['英語', '国語', '数学IA', '数学IIBC', '化学基礎', '物理基礎'],
                    'desired_schools' => ['広島大学総合科学部'],
                    'note' => '文理未定。定期的に進路面談を実施。',
                ],
                'assignments' => [
                    [
                        'teacher_index' => 1,
                        'subjects' => ['英語', '数学IA'],
                    ],
                ],
            ],
        ];

        foreach ($students as $index => $row) {
            $studentData = $row['student'];

            if ($consultantUsers->isNotEmpty()) {
                $studentData['consultant_user_id'] = $consultantUsers[$index % $consultantUsers->count()]->id;
            }

            $student = Student::create($studentData);

            $teacherIds = [];
            $subjectRows = [];

            foreach ($row['assignments'] as $assignment) {
                if ($teachers->isEmpty()) {
                    continue;
                }

                $teacher = $teachers[$assignment['teacher_index'] % $teachers->count()];
                $teacherIds[] = $teacher->id;

                $availableSubjects = $teacher->teacherSubjects->pluck('subject')->all();

                foreach ($assignment['subjects'] as $subject) {
                    if (! in_array($subject, $availableSubjects, true)) {
                        continue;
                    }

                    $subjectRows[] = [
                        'student_id' => $student->id,
                        'teacher_id' => $teacher->id,
                        'subject' => $subject,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (! empty($teacherIds)) {
                $student->teachers()->sync(array_values(array_unique($teacherIds)));
            }

            if (! empty($subjectRows)) {
                StudentTeacherSubject::insert($subjectRows);
            }
        }
    }
}