<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $student->name }} 学習記録一覧</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: mplus1, sans-serif;
            font-size: 12px;
            line-height: 1.7;
            color: #222;
            margin: 24px;
        }

        p {
            margin: 0;
            padding: 4px 0;
            width: 100%;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 12px;
            text-align: center;
        }

        .section {
            margin-bottom: 18px;
        }

        .profile-box {
            margin-bottom: 20px;
            padding: 12px 14px;
        }

        .profile-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid #999;
        }

        .profile-row {
            padding: 4px 0;
        }

        .profile-label {
            font-weight: bold;
        }

        .teacher-row,
        .school-row {
            padding-left: 8px;
        }

        .record {
            margin-bottom: 20px;
            padding-bottom: 14px;
        }

        .record-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid #999;
        }

        .box {
            padding: 8px 10px;
            margin-top: 8px;
            background-color: #f7f7f7;
        }

        .label {
            font-weight: bold;
            margin-bottom: 4px;
            border-left: 4px solid #4a4a4a;
            padding-left: 6px;
            padding-bottom: 0px;
            letter-spacing: 1px;
        }

        .muted {
            color: #666;
        }
    </style>
</head>
<body>
    @php
        $courseTypeLabel = match ($student->course_type ?? null) {
            'liberal_arts' => '文系',
            'science' => '理系',
            'undecided' => '未定',
            default => '未設定',
        };

        $statusLabel = match ($student->status ?? null) {
            'active' => '在籍中',
            'leave' => '休塾',
            'graduated' => '卒業',
            'withdrawn' => '退塾',
            default => '未設定',
        };

        $schools = array_values(array_filter($student->desired_schools ?? [], fn ($v) => filled($v)));
    @endphp

    <div class="title">自習コンサルティング記録一覧</div>

    <div class="section">
        <div class="profile-box">
            <div class="profile-title">生徒情報</div>

            <p class="profile-row">
                <span class="profile-label">生徒氏名：</span>{{ $student->name ?: '未設定' }}
                @if (!empty($student->name_kana))
                    （{{ $student->name_kana }}）
                @endif
            </p>

            <p class="profile-row">
                <span class="profile-label">学校名：</span>{{ $student->school_name ?: '未設定' }}（{{ $student->grade ?: '未設定' }} / 文理選択：{{ $courseTypeLabel }}）
            </p>

            <p class="profile-row">
                <span class="profile-label">ステータス：</span>{{ $statusLabel }}
            </p>

            <p class="profile-row">
                <span class="profile-label">コンサル担当：</span>{{ $student->consultant?->name ?? '未設定' }}
            </p>

            <div class="profile-row">
                <span class="profile-label">担当講師・担当科目：</span>
                @if ($student->teachers->isNotEmpty())
                    @foreach ($student->teachers as $teacher)
                        @php
                            $assignedSubjects = $student->studentTeacherSubjects
                                ->where('teacher_id', $teacher->id)
                                ->pluck('subject')
                                ->values()
                                ->all();
                        @endphp
                        <p class="teacher-row">
                            ・{{ $teacher->name }}
                            @if (!empty($assignedSubjects))
                                → {{ implode(', ', $assignedSubjects) }}
                            @else
                                → 担当科目未設定
                            @endif
                        </p>
                    @endforeach
                @else
                    <span class="muted">未設定</span>
                @endif
            </div>

            <p class="profile-row">
                <span class="profile-label">受験科目：</span>
                @if (!empty($student->exam_subjects))
                    {{ implode('・', $student->exam_subjects) }}
                @else
                    未設定
                @endif
            </p>

            <div class="profile-row">
                <span class="profile-label">志望校：</span>
                @if (!empty($schools))
                    @foreach ($schools as $school)
                        <p class="school-row">・{{ $school }}</p>
                    @endforeach
                @else
                    <span class="muted">未設定</span>
                @endif
            </div>

            <div class="profile-row">
                <span class="profile-label">備考：</span>
                <p>{!! nl2br(e($student->note ?: '未設定')) !!}</p>
            </div>
        </div>
    </div>

    @forelse ($records as $record)
        <pagebreak />

        <div class="record">
            <div class="record-title">
                実施日：{{ $record->consulted_at?->format('Y/m/d H:i') ?: '未設定' }} ▶︎ 次回実施日：{{ $record->next_plan_date?->format('Y/m/d H:i') ?: '未設定' }}
            </div>

            <div>
                <strong>記録者：</strong>{{ $record->user->name ?? '未設定' }}　<strong>自己評価：</strong>{{ !is_null($record->self_score) ? $record->self_score . ' / 100 点' : '未入力' }}
            </div>

            <div class="box">
                <div class="label">成長点</div>
                {!! nl2br(e($record->growth_point ?: '未入力')) !!}
            </div>

            <div class="box">
                <div class="label">課題点</div>
                {!! nl2br(e($record->challenge_point ?: '未入力')) !!}
            </div>

            <div class="box">
                <div class="label">NOTE</div>
                {!! nl2br(e($record->note ?: '未入力')) !!}
            </div>

            @if ($record->subject1_name || $record->subject1_detail)
                <div class="box">
                    <div class="label">科目① {{ $record->subject1_name ?: '未設定' }}</div>
                    {!! nl2br(e($record->subject1_detail ?: '未入力')) !!}
                </div>
            @endif

            @if ($record->subject2_name || $record->subject2_detail)
                <div class="box">
                    <div class="label">科目② {{ $record->subject2_name ?: '未設定' }}</div>
                    {!! nl2br(e($record->subject2_detail ?: '未入力')) !!}
                </div>
            @endif

            @if ($record->subject3_name || $record->subject3_detail)
                <div class="box">
                    <div class="label">科目③ {{ $record->subject3_name ?: '未設定' }}</div>
                    {!! nl2br(e($record->subject3_detail ?: '未入力')) !!}
                </div>
            @endif

            <div class="box">
                <div class="label">その他</div>
                {!! nl2br(e($record->other_plan ?: '未入力')) !!}
            </div>
        </div>
    @empty
        <p>学習記録はありません。</p>
    @endforelse
</body>
</html>