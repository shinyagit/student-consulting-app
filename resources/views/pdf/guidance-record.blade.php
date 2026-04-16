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
            font-size: 14px;
            line-height: 1.6;
            margin: 24px;
        }

        p {
            padding: 4px;
            margin: 0;
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
            min-height: 150px;
            padding: 28px 8px 8px;
            border: 2px solid #333;
            margin-bottom: 5px;
        }

        .review-box span {
            position: absolute;
            top: 4px;
            left: 8px;
        }

        .self-review {
            text-align: right;
            font-weight: bold;
        }

        .logo-box {
            position: absolute;
            bottom: 70px;
            left: 0;
            height: 50px;
            text-align: center;
        }

        .logo-box img {
            width: 100px;
            height: auto;
        }

        .box {
            border: 2px solid #333;
            min-height: 60px;
            padding: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th,
        td {
            border: 2px solid #333;
            padding: 8px;
            vertical-align: top;
            text-align: left;
            height: 120px;
            line-height: 1.6em;
        }

        th {
            width: 20%;
            background: #f5f5f5;
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
    @endphp

    <div class="title">広大研 自習コンサルティング</div>

    <div class="section">
        <p class="date">
            <strong>実施日：</strong>
            @if ($record->consulted_at)
                {{ $consultDate }} {{ $consultDay }} {{ $consultTime }}
            @else
                未設定
            @endif
        </p>
        <p class="name"><strong>生徒名：</strong>{{ $record->student->name ?? '未設定' }}</p>
        <p class="name"><strong>記録者：</strong>{{ $record->user->name ?? '未設定' }}</p>
    </div>

    <div class="section">
        <div class="section-title">– 前回コンサルティングから今日までの振り返り –</div>

        <div class="review-box">
            <span><strong>◎ 成長点</strong></span>
            <p>{{ $record->growth_point ?: '未入力' }}</p>
        </div>

        <div class="review-box">
            <span><strong>△ 課題点</strong></span>
            <p>{{ $record->challenge_point ?: '未入力' }}</p>
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

        <p><strong>NOTE</strong></p>
        <div class="review-box">
            <p>{{ $record->note ?: '未入力' }}</p>
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
            次回までの計画：
            @if ($record->next_plan_date)
                {{ $nextDate }} {{ $nextDay }} {{ $nextTime }}
            @else
                未設定
            @endif
        </div>

        <table>
            <tr>
                <td>
                    <strong>科目①（{{ $record->subject1_name ?: '未設定' }}）</strong><br>
                    {{ $record->subject1_detail ?: '未入力' }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>科目②（{{ $record->subject2_name ?: '未設定' }}）</strong><br>
                    {{ $record->subject2_detail ?: '未入力' }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>科目③（{{ $record->subject3_name ?: '未設定' }}）</strong><br>
                    {{ $record->subject3_detail ?: '未入力' }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>その他</strong><br>
                    {{ $record->other_plan ?: '未入力' }}
                </td>
            </tr>
        </table>
    </div>
</body>
</html>