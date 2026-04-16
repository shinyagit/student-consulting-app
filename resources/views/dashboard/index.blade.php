@extends('layouts.app')

@section('title', 'ダッシュボード')

@section('content')
    <section class="dashboard">
        <div class="dashboard__header">
            <h1 class="dashboard__title">ダッシュボード</h1>
            <p class="dashboard__subtitle">生徒・講師・学習記録の状況を一覧で確認できます。</p>
        </div>

        <div class="dashboard-stats">
            <div class="stat-card stat-card--students">
                <p class="stat-card__label">生徒数</p>
                <p class="stat-card__value">{{ $studentCount }}</p>
            </div>

            <div class="stat-card stat-card--teachers">
                <p class="stat-card__label">講師数</p>
                <p class="stat-card__value">{{ $teacherCount }}</p>
            </div>

            <div class="stat-card stat-card--records">
                <p class="stat-card__label">学習記録数</p>
                <p class="stat-card__value">{{ $recordCount }}</p>
            </div>
        </div>

        <section class="dashboard-panel">
            <div class="dashboard-panel__header">
                <h2 class="dashboard-panel__title">最近の記録</h2>
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
                                    <td class="dashboard-table__name">{{ $student->name ?? '-' }}</td>
                                    <td>{{ $student->school_name ?? '-' }}</td>
                                    <td>{{ $student->grade ?? '-' }}</td>
                                    <td>
                                        @if (!empty($schools))
                                            {{ $schools[0] }}
                                            @if (count($schools) > 1)
                                                <span class="dashboard-table__more">＋{{ count($schools) - 1 }}</span>
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
                                                <a href="{{ route('students.show', $student) }}" class="button">詳細</a>
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