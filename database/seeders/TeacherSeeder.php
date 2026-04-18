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
                    'name' => '閑田拓真',
                    'department' => '広島大学文学部人文学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月17:00以降、火17:00以降、水17:00以降、木17:00以降、金17:00以降',
                        '大下、高村、祢宜、崎山、茨木、古川、久保'
                    ),
                ],
                'subjects' => ['英語'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T002',
                    'name' => '髙橋哲野',
                    'department' => '広島大学医学部医学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '火17:00以降、木17:00以降、金17:00以降、日10:00以降',
                        '崎山、葛城、福岡'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '英語', '化学', '生物', '地理'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T003',
                    'name' => '桑原萌音',
                    'department' => '広島大学医学部医学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月17:00以降、火17:00以降、木17:00以降、土17:00以降、日17:00以降',
                        '祢宜、崎山、中村、土肥、小西'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '英語', '物理', '化学', '日本史'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T004',
                    'name' => '水田幸希',
                    'department' => '広島大学医学部医学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月17:00以降、金17:00以降、日13:00以降',
                        '久保、三宅'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '物理', '化学'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T005',
                    'name' => '池田さん',
                    'department' => '広島大学経済学部経済学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '未登録',
                        '島谷、森',
                        '学部学科・担当可能科目・出講可能曜日が未登録'
                    ),
                ],
                'subjects' => [],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T006',
                    'name' => '河上りえ',
                    'department' => '広島大学歯学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '水20:00以降、木17:00以降、金17:00以降、日10:00以降',
                        '山本、相馬、上川'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '英語', '国語', '生物', '日本史'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T007',
                    'name' => '髙垣翔生',
                    'department' => '広島大学工学部第3類',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月16:00以降、火16:00以降、水16:00以降、木16:00以降、金16:00以降、土09:00以降、日09:00以降',
                        '沖野、小川'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '英語', '国語', '物理', '化学'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T008',
                    'name' => '柏木優仁',
                    'department' => '広島大学医学部医学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '火17:00以降、水17:00以降、木17:00以降',
                        '吉岡、宮田'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '英語', '国語', '物理', '化学', '生物'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T009',
                    'name' => '藤井晃大',
                    'department' => '広島大学医学部医学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '火13:00以降、木13:00以降、土13:00以降、日13:00以降',
                        '金本、相馬、金光、林'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '英語'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T010',
                    'name' => '原田晃誠',
                    'department' => '広島大学医学部医学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '火17:00以降、木17:00以降、金17:00以降',
                        '森、金光'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '英語', '国語'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T011',
                    'name' => '古賀俊輝',
                    'department' => '広島大学医学部医学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '火18:00以降、木18:00以降、土17:00以降',
                        '吉本、前川'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '英語', '国語', '物理', '化学', '日本史'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T012',
                    'name' => '春口駿輔',
                    'department' => '広島大学歯学部歯学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月20:30以降、火20:30以降、水18:00以降、木18:00以降、金18:00以降、土14:00以降、日10:00以降',
                        '樋口、大町、羽田、谷本、土肥'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '国語', '化学', '生物', '地理'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T013',
                    'name' => '添木昂大',
                    'department' => '広島大学歯学部歯学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '木17:30以降、金17:30以降、土10:00以降',
                        '大町、重住、中元、斎藤、三谷'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '英語', '物理', '化学'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T014',
                    'name' => '木村優希',
                    'department' => '広島大学医学部医学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月17:00以降、火17:00以降、水17:00以降、木17:00以降、金17:00以降、土11:00以降、日11:00以降',
                        '山田、櫟本、土肥、藤田'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '英語', '物理', '化学'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T015',
                    'name' => '藤井朝陽',
                    'department' => '広島大学薬学部薬学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月18:00以降、火20:00以降、木17:00以降、金20:00以降、日17:00以降',
                        '山田、佐和'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '英語', '化学', '生物', '地理'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T016',
                    'name' => '塩田海渡',
                    'department' => '広島大学薬学部薬学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '土18:00以降、日18:00以降',
                        '櫟本、手嶋'
                    ),
                ],
                'subjects' => ['英語', '国語', '生物', '地理'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T017',
                    'name' => '中津光喜',
                    'department' => '広島大学理学部物理学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '火20:00以降、木20:00以降、金20:00以降、土17:30以降、日17:30以降',
                        '紙本、森、国岡、藤田'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '物理', '化学'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T018',
                    'name' => '峯大心',
                    'department' => '広島大学医学部医学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '土09:00以降、日09:00以降',
                        '大町、村井、尾村'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '英語', '物理', '化学'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T019',
                    'name' => '在津凌馬',
                    'department' => '広島大学経済学部経済学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月18:00以降、火18:00以降、水18:00以降、木18:00以降、金18:00以降、土18:00以降、日18:00以降',
                        '金本、福岡、里吉、広瀬、黒目'
                    ),
                ],
                'subjects' => ['英語', '国語'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T020',
                    'name' => '大久保優',
                    'department' => '広島大学情報科学部情報科学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月19:30以降、火19:30以降、木18:30以降、金18:30以降、日13:00以降',
                        '新迫'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T021',
                    'name' => '角谷亮介',
                    'department' => '広島大学医学部医学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月19:30以降、火17:00以降、水19:30以降、木19:30以降、金17:00以降、土13:00以降、日13:00以降',
                        '広瀬'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '英語', '物理', '化学'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T022',
                    'name' => '大西翔',
                    'department' => '広島大学法学部法学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '火17:00以降、水19:00以降、木17:00以降、土15:00以降、日12:00以降',
                        '高村、丸子、重住'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '英語', '国語', '日本史', '世界史', '倫理', '政治経済'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T023',
                    'name' => '木村澤旭',
                    'department' => '広島大学歯学部歯学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '日14:00以降',
                        '城岸、高村、櫛部、今西、梁'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '英語', '国語', '物理', '化学'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T024',
                    'name' => '高島沙良',
                    'department' => '広島大学法学部法学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月19:00以降、土12:00以降、日17:00以降',
                        '秋山、大下'
                    ),
                ],
                'subjects' => ['英語', '国語', '世界史', '地理'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T026',
                    'name' => '波見伊吹',
                    'department' => '広島大学法学部法学科昼間コース',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月18:00以降、火20:00以降、水18:00以降、木18:00以降、金18:00以降、土10:30以降、日10:30以降',
                        '高村、岡、多田、小西、吉田'
                    ),
                ],
                'subjects' => ['英語', '国語', '日本史', '世界史'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T027',
                    'name' => '大本航生',
                    'department' => '広島大学医学部医学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '火16:00以降、金16:00以降、土16:00以降、日16:00以降',
                        '木下、上川'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '英語', '物理', '化学'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T028',
                    'name' => '山田凌雅',
                    'department' => '広島大学歯学部歯学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月17:00以降、水17:00以降',
                        '宮本、上川'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '英語', '化学'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T029',
                    'name' => '德弘雄亮',
                    'department' => '広島大学医学部医学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月17:00以降、火17:00以降、水17:00以降、木17:00以降、金17:00以降、土10:00以降、日10:00以降',
                        '大下、吉田、山田'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '物理', '化学'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T030',
                    'name' => '谷村倖',
                    'department' => '広島大学医学部医学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月18:00以降、火18:00以降、水18:00以降、木18:00以降、金18:00以降',
                        '黒目、山田'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '英語', '物理', '化学', '世界史'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T031',
                    'name' => '守田澪奈',
                    'department' => '広島大学医学部医学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '土10:00以降',
                        '藤井'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '英語'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T032',
                    'name' => '夏健弘',
                    'department' => '広島大学歯学部歯学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '火17:00以降、木20:30以降、金17:00以降、土09:00以降、日09:00以降',
                        '大町、小林'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '化学'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T033',
                    'name' => '石井夏乃',
                    'department' => '広島大学法学部法学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月09:00以降、火09:00以降、水09:00以降、木09:00以降、金09:00以降、土13:00以降、日13:00以降',
                        '大町、小林'
                    ),
                ],
                'subjects' => ['国語', '倫理', '政治経済', '地理'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T034',
                    'name' => '粟田弓月',
                    'department' => '広島大学法学部昼間コース',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月18:00以降、水18:00以降、木18:00以降、金18:00以降',
                        '吉本、森井、細國、松村、小林、斎藤'
                    ),
                ],
                'subjects' => ['英語', '国語', '倫理', '政治経済'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T035',
                    'name' => '楠原輝士',
                    'department' => '広島大学歯学部歯学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月18:00以降、金18:00以降、土16:00以降、日12:00以降',
                        '木下、松村、細國、岡本、古川、吉岡'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '国語', '日本史', '世界史'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T036',
                    'name' => '森上愼士',
                    'department' => '広島大学法学部法学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '火17:00以降、木17:00以降、金17:00以降',
                        '山口、池本、内山、片山、山本'
                    ),
                ],
                'subjects' => ['英語', '国語', '世界史', '倫理', '政治経済'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T037',
                    'name' => '竹本龍',
                    'department' => '広島大学法学科夜間主コース',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '火09:00以降、水09:00以降、木13:00以降、金09:00以降、土09:00以降、日09:00以降',
                        '坂田、岡'
                    ),
                ],
                'subjects' => ['英語', '国語', '日本史', '政治経済', '倫理'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T038',
                    'name' => '木村悠',
                    'department' => null,
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '未登録',
                        '内山、脇田',
                        '学部学科・担当可能科目・出講可能曜日が未登録'
                    ),
                ],
                'subjects' => [],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T039',
                    'name' => '亀尾建彦',
                    'department' => '広島大学医学部医学科',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月17:30以降、火18:00以降、水18:00以降、木18:00以降、金18:00以降',
                        '池本、諸岡'
                    ),
                ],
                'subjects' => ['数学IA', '数学IIBC', '数学III', '英語', '国語', '物理', '化学', '政治経済', '倫理', '地理'],
            ],
            [
                'teacher' => [
                    'teacher_code' => 'T040',
                    'name' => '今井信秀',
                    'department' => '広島大学法学科昼間コース',
                    'school_year' => '1年',
                    'age' => 20,
                    'status' => 'active',
                    'note' => $this->buildNote(
                        '月10:30以降、木13:00以降、日13:00以降',
                        '山本'
                    ),
                ],
                'subjects' => ['英語', '国語', '日本史', '倫理', '政治経済'],
            ],
        ];

        foreach ($teachers as $row) {
            $teacher = Teacher::updateOrCreate(
                ['teacher_code' => $row['teacher']['teacher_code']],
                $row['teacher']
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

    private function buildNote(string $availableDays, string $students, ?string $extra = null): string
    {
        $parts = [
            "出講可能曜日: {$availableDays}",
            "担当生徒: {$students}",
        ];

        if ($extra) {
            $parts[] = $extra;
        }

        return implode("\n", $parts);
    }
}