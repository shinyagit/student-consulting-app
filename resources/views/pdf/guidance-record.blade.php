<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>自習コンサルティング記録</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            position: relative;
            font-family: mplus1, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            margin: 24px;
        }

        p {
            padding: 4px;
            margin: 0;
            width: 100%;
        }

        .kana {
            font-size: 10px;
            color: #4a4a4a;
        }

        .school {
            color: #4a4a4a;
            font-size: 14px;
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .date,
        .name {
            font-size: 18px;
        }

        .section-title {
            margin-bottom: 8px;
            padding-bottom: 4px;
            font-weight: bold;
        }

        .review-box {
            position: relative;
            height: 140px;
            padding: 8px;
            border: 2px solid #333;
            margin-bottom: 5px;
        }

        .self-review {
            text-align: right;
            font-weight: bold;
        }

        .note-title {
            border-bottom: 1px solid #333;
            padding-left: 8px;
            padding-top: 0;
            margin-top: 2em;
            font-size: 15px;
            line-height: 1.4;
            font-weight: bold;
        }

        .note-box {
            position: relative;
            /* height: 240px; */
            padding: 4px 0 4px 4px;
            /* border: 2px solid #333; */
        }

        .next-title {
            padding-left: 8px;
            font-size: 15px;
            line-height: 1.4;
            font-weight: bold;
        }

        .next-box {
            position: relative;
            padding: 4px 0 2em 4px;
            margin-bottom: 4px;
            border: 2px solid #333;
        }

        .logo-box {
            position: absolute;
            bottom: 70px;
            left: 0;
            height: 40px;
            text-align: center;
        }

        .logo-box img {
            width: 100%;
            height: auto;
        }

        .box {
            border: 2px solid #333;
            min-height: 40px;
            padding: 8px;
        }
    </style>
</head>
<body>
    @php
        $week = ['(日)', '(月)', '(火)', '(水)', '(木)', '(金)', '(土)'];

        $consultDate = $record->consulted_at?->format('Y/m/d');
        $consultDayIndex = $record->consulted_at?->format('w');
        $consultDay = !is_null($consultDayIndex) ? $week[(int) $consultDayIndex] : '';
        $consultTime = $record->consulted_at?->format('H:i');

        $nextDate = $record->next_plan_date?->format('Y/m/d');
        $nextDayIndex = $record->next_plan_date?->format('w');
        $nextDay = !is_null($nextDayIndex) ? $week[(int) $nextDayIndex] : '';
        $nextTime = $record->next_plan_date?->format('H:i');

        $logoPath = public_path('/images/hirodaiken_logo_fix.png');
        $logoBase64 = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;
        $courseTypeLabel = match ($record->student->course_type ?? null) {
            'liberal_arts' => '文系',
            'science' => '理系',
            'undecided' => '未定',
            default => '',
        };
    @endphp

    <div class="title">広大研 自習コンサルティング</div>

    <div class="section">
        <p class="date">
            <strong>実施日：
            @if ($record->consulted_at)
                {{ $consultDate }} {{ $consultDay }} {{ $consultTime }}
            @else
                未設定
            @endif
            </strong>
        </p>
        <p class="name">
            <strong>生徒名：{{ $record->student->name ?? '未設定' }} </strong>
            <small class="kana">{{ $record->student->name_kana ?? '' }}</small>
            <span class="school">
                （{{ $record->student->school_name ?? '' }}
                @if(!empty($record->student->grade))
                    / {{ $record->student->grade }}
                @endif
                @if(!empty($courseTypeLabel))
                    / {{ $courseTypeLabel }}
                @endif
                ）
            </span>
        </p>
        <!-- <p class="name"><strong>記録者：</strong>{{ $record->user->name ?? '未設定' }}</p> -->
    </div>

    <div class="section">
        <div class="section-title">– 前回コンサルティングから今回までの振り返り –</div>

        <div class="review-box">
            <span><strong>◎ 成長点</strong></span>
            <p>{!! nl2br(e($record->growth_point ?: '未入力' )) !!}</p>
        </div>

        <div class="review-box">
            <span><strong>△ 課題点</strong></span>
            <p>{!! nl2br(e( $record->challenge_point ?: '未入力' )) !!}</p>
        </div>

        <p class="self-review">
            <strong>
                自己評価：
                @if (!is_null($record->self_score))
                    {{ $record->self_score }} / 100 点
                @else
                    未入力
                @endif
            </strong>
        </p>

        <p class="note-title"><strong>NOTE</strong></p>
        <div class="note-box">
            <p>{!! nl2br(e( $record->note ?: '未入力' )) !!}</p>
        </div>
    </div>

    @if ($logoBase64)
        <div class="logo-box">
            <img src="data:image/png;base64,{{ $logoBase64 }}" alt="広大研ロゴ">
        </div>
    @endif

    <pagebreak />

    <div class="section">
        <div class="section-title">
            次回までの計画（次回：
            @if ($record->next_plan_date)
                {{ $nextDate }} {{ $nextDay }} {{ $nextTime }} 〜
            @else
                未設定
            @endif
            ）
        </div>
            
            <div class="next-box">
                <p class="next-title">科目① - {{ $record->subject1_name ?: '未設定' }}</p>
                <p>{!! nl2br(e( $record->subject1_detail ?: '未入力' )) !!}</p>
            </div>

            
            <div class="next-box">
                <p class="next-title">科目② - {{ $record->subject2_name ?: '未設定' }}</p>
                <p>{!! nl2br(e( $record->subject2_detail ?: '未入力' )) !!}</p>
            </div>

            
            <div class="next-box">
                <p class="next-title">科目③ - {{ $record->subject3_name ?: '未設定' }}</p>
                <p>{!! nl2br(e( $record->subject3_detail ?: '未入力' )) !!}</p>
            </div>

            <p class="note-title">その他</p>
            <div class="note-box">
                <p>{!! nl2br(e( $record->other_plan ?: '未入力' )) !!}</p>
            </div>
    </div>
</body>
</html>