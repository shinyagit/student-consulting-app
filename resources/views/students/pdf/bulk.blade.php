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

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        .meta-table th,
        .meta-table td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            vertical-align: top;
            text-align: left;
        }

        .meta-table th {
            width: 24%;
            background: #f5f5f5;
        }

        .record {
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px dashed #999;
        }

        .record-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid #999;
        }

        .box {
            border: 1px solid #ccc;
            padding: 8px 10px;
            margin-top: 8px;
        }

        .label {
            font-weight: bold;
            margin-bottom: 4px;
        }

        .teacher-row {
            margin-bottom: 4px;
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
    @endphp

    <div class="title">自習コンサルティング記録一覧</div>

    <div class="section">
        <table class="meta-table">
            <tr>
                <th>生徒氏名</th>
                <td>{{ $student->name ?: '未設定' }}</td>
                <th>ふりがな</th>
                <td>{{ $student->name_kana ?: '未設定' }}</td>
            </tr>
            <tr>
                <th>学校名</th>
                <td>{{ $student->school_name ?: '未設定' }}</td>
                <th>学年</th>
                <td>{{ $student->grade ?: '未設定' }}</td>
            </tr>
            <tr>
                <th>文理</th>
                <td>{{ $courseTypeLabel }}</td>
                <th>ステータス</th>
                <td>{{ $statusLabel }}</td>
            </tr>
            <tr>
                <th>コンサル担当</th>
                <td colspan="3">{{ $student->consultant?->name ?? '未設定' }}</td>
            </tr>
            <tr>
                <th>担当講師 / 担当科目</th>
                <td colspan="3">
                    @if ($student->teachers->isNotEmpty())
                        @foreach ($student->teachers as $teacher)
                            @php
                                $assignedSubjects = $student->studentTeacherSubjects
                                    ->where('teacher_id', $teacher->id)
                                    ->pluck('subject')
                                    ->values()
                                    ->all();
                            @endphp
                            <div class="teacher-row">
                                {{ $teacher->name }}
                                @if (!empty($assignedSubjects))
                                    ：{{ implode('、', $assignedSubjects) }}
                                @else
                                    ：担当科目未設定
                                @endif
                            </div>
                        @endforeach
                    @else
                        <span class="muted">未設定</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>受験科目</th>
                <td colspan="3">
                    @if (!empty($student->exam_subjects))
                        {{ implode('、', $student->exam_subjects) }}
                    @else
                        未設定
                    @endif
                </td>
            </tr>
            <tr>
                <th>志望校</th>
                <td colspan="3">
                    @php
                        $schools = array_values(array_filter($student->desired_schools ?? [], fn ($v) => filled($v)));
                    @endphp

                    @if (!empty($schools))
                        {{ implode('、', $schools) }}
                    @else
                        未設定
                    @endif
                </td>
            </tr>
            <tr>
                <th>備考</th>
                <td colspan="3">{!! nl2br(e($student->note ?: '未設定')) !!}</td>
            </tr>
        </table>
    </div>

    @forelse ($records as $record)
        <div class="record">
            <div class="record-title">
                実施日：{{ $record->consulted_at?->format('Y/m/d H:i') ?: '未設定' }}
            </div>

            <div><strong>記録者：</strong>{{ $record->user->name ?? '未設定' }}</div>
            <div><strong>自己評価：</strong>{{ !is_null($record->self_score) ? $record->self_score . ' / 100 点' : '未入力' }}</div>
            <div><strong>次回実施日時：</strong>{{ $record->next_plan_date?->format('Y/m/d H:i') ?: '未設定' }}</div>

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