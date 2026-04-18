@extends('layouts.app')

@section('title', 'ダッシュボード')

@section('content')
    <section class="dashboard dashboard-page">
        <div class="page-header">
            <div>
                <p class="page-eyebrow">Dashboard</p>
                <h1 class="page-title">ダッシュボード</h1>
                <p class="page-subtitle">生徒・講師・学習記録の状況を一覧で確認できます。</p>
            </div>
        </div>

        <!-- <p class="text-default">これはUI確認用のダミー文章です。2026/04/17 15:30、version2.1.0、TeacherCode=T040、StudentNo=A-204、mode=preview といった英数字を含みつつ、ひらがな、カタカナ、漢字を自然に混在させています。表示崩れ、文字間、禁則処理、折り返し位置、ボタン横の余白、フォーム下の説明文の見え方などをチェックする目的で作成したサンプルテキストです。</p>
        <p class="text-sm">これはUI確認用のダミー文章です。2026/04/17 15:30、version2.1.0、TeacherCode=T040、StudentNo=A-204、mode=preview といった英数字を含みつつ、ひらがな、カタカナ、漢字を自然に混在させています。表示崩れ、文字間、禁則処理、折り返し位置、ボタン横の余白、フォーム下の説明文の見え方などをチェックする目的で作成したサンプルテキストです。</p>
        <p class="text-md">これはUI確認用のダミー文章です。2026/04/17 15:30、version2.1.0、TeacherCode=T040、StudentNo=A-204、mode=preview といった英数字を含みつつ、ひらがな、カタカナ、漢字を自然に混在させています。表示崩れ、文字間、禁則処理、折り返し位置、ボタン横の余白、フォーム下の説明文の見え方などをチェックする目的で作成したサンプルテキストです。</p>
        <p class="text-lg">これはUI確認用のダミー文章です。2026/04/17 15:30、version2.1.0、TeacherCode=T040、StudentNo=A-204、mode=preview といった英数字を含みつつ、ひらがな、カタカナ、漢字を自然に混在させています。表示崩れ、文字間、禁則処理、折り返し位置、ボタン横の余白、フォーム下の説明文の見え方などをチェックする目的で作成したサンプルテキストです。</p>
        <p class="text-hg">これはUI確認用のダミー文章です。2026/04/17 15:30、version2.1.0、TeacherCode=T040、StudentNo=A-204、mode=preview といった英数字を含みつつ、ひらがな、カタカナ、漢字を自然に混在させています。表示崩れ、文字間、禁則処理、折り返し位置、ボタン横の余白、フォーム下の説明文の見え方などをチェックする目的で作成したサンプルテキストです。</p> -->

        <div class="dashboard-stats">
            <div class="stat-card stat-card-students">
                @if(auth()->user()->role === 'staff')
                    <p class="stat-card-label">担当生徒数</p>
                @else
                    <p class="stat-card-label">全生徒数</p>
                @endif
                <p class="stat-card-value">{{ $studentCount }}</p>
            </div>

            <div class="stat-card stat-card-teachers">
                <p class="stat-card-label">講師数</p>
                <p class="stat-card-value">{{ $teacherCount }}</p>
            </div>

            <div class="stat-card stat-card-records">
                <p class="stat-card-label">学習記録数</p>
                <p class="stat-card-value">{{ $recordCount }}</p>
            </div>
        </div>

        <section class="table-panel">
            <div class="table-panel-header">
                <h2 class="table-panel-title">最近の記録</h2>
            </div>

            @if ($recentRecords->isEmpty())
                <div class="empty-state">
                    <p>記録はまだありません。</p>
                </div>
            @else
                @php
                    $week = ['(日)', '(月)', '(火)', '(水)', '(木)', '(金)', '(土)'];
                @endphp

                <div class="table-wrap">
                    <table class="base-table dashboard-table">
                        <thead>
                            <tr>
                                <th>実施日時</th>
                                <th>生徒名</th>
                                <th>学校名</th>
                                <th>学年</th>
                                <th>志望校</th>
                                <th>コンサル担当</th>
                                <th>記録数</th>
                                @auth
                                    @if(auth()->user()->role === 'admin')
                                        <th></th>
                                    @endif
                                @endauth
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentRecords as $record)
                                @php
                                    $student = $record->student;
                                    $schools = array_values(array_filter($student->desired_schools ?? [], fn ($v) => filled($v)));
                                @endphp

                                <tr>
                                    <td>
                                        @if ($record->consulted_at)
                                            {{ $record->consulted_at->format('Y/m/d') }}
                                            {{ $week[$record->consulted_at->dayOfWeek] }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="panel-table-name">{{ $student->name ?? '-' }}</td>
                                    <td>{{ $student->school_name ?? '-' }}</td>
                                    <td>{{ $student->grade ?? '-' }}</td>
                                    <td>
                                        @if (!empty($schools))
                                            {{ $schools[0] }}
                                            @if (count($schools) > 1)
                                                <span class="school-more-badge">＋{{ count($schools) - 1 }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted">未設定</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $student->consultant?->name ?? '未設定' }}
                                    </td>
                                    <td>
                                        <span class="record-count-badge">
                                            {{ $student->guidance_records_count ?? 0 }}
                                        </span>
                                    </td>
                                    @auth
                                        @if(auth()->user()->role === 'admin')
                                            <td>
                                                <a href="{{ route('students.show', $student) }}" class="table-button table-button-detail">詳細</a>
                                            </td>
                                        @endif
                                    @endauth
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </section>
@endsection