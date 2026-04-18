@extends('layouts.app')

@section('title', '生徒詳細')

@section('content')
    <section class="section-wrapper">
        <div class="page-header">
            <div>
                <p class="page-eyebrow">Students</p>
                <h1 class="page-title">生徒詳細</h1>
            </div>

            <div class="page-header-actions">
                <!-- @can('view', $student)
                    <a href="{{ route('guidance-records.create', ['student_id' => $student->id]) }}" class="button">
                        記録を追加
                    </a>
                @endcan -->

                @can('update', $student)
                    <a href="{{ route('students.edit', $student) }}" class="table-button table-button-edit">
                        編集
                    </a>
                @endcan
            </div>
        </div>

        <section class="ui-detail-section detail-card">
            <div class="ui-detail-section-header">
                <p class="ui-detail-section-eyebrow">Student Profile</p>
                <h2 class="ui-detail-section-title">基本情報</h2>
            </div>

            <div class="ui-detail-list">
                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">生徒氏名</div>
                    <div class="ui-detail-list-value">{{ $student->name }}　<span class="name-kana">{{ $student->name_kana ?: '未設定' }}</span></div>
                </div>

                <!-- <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">生徒氏名ふりがな</div>
                    <div class="ui-detail-list-value">{{ $student->name_kana ?: '未設定' }}</div>
                </div> -->

                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">学校名 / 学年 / 文理選択</div>
                    <div class="ui-detail-list-value">{{ $student->school_name ?: '未設定' }} / {{ $student->grade ?: '未設定' }} / 
                        @switch($student->course_type)
                            @case('liberal_arts')
                                文系
                                @break
                            @case('science')
                                理系
                                @break
                            @case('undecided')
                                未定
                                @break
                            @default
                                未設定
                        @endswitch
                    </div>
                </div>

                <!-- <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">学年</div>
                    <div class="ui-detail-list-value">{{ $student->grade ?: '未設定' }}</div>
                </div> -->

                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">部活 / 引退時期</div>
                    <div class="ui-detail-list-value">{{ $student->club_activity ?: '未登録' }} / {{ $student->club_retirement_timing ?: '未登録' }}</div>
                </div>

                <!-- <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">部活引退時期</div>
                    <div class="ui-detail-list-value">{{ $student->club_retirement_timing ?: '未登録' }}</div>
                </div> -->

                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">ステータス</div>
                    <div class="ui-detail-list-value">
                        @switch($student->status)
                            @case('active')
                                <span class="ui-status-chip ui-status-chip--primary">在籍中</span>
                                @break
                            @case('leave')
                                <span class="ui-status-chip ui-status-chip--accent">休会</span>
                                @break
                            @case('graduated')
                                <span class="ui-status-chip ui-status-chip--secondary">卒業</span>
                                @break
                            @case('withdrawn')
                                <span class="ui-status-chip ui-status-chip--muted">退塾</span>
                                @break
                            @default
                                {{ $student->status ?: '未設定' }}
                        @endswitch
                    </div>
                </div>

                <!-- <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">文系理系</div>
                    <div class="ui-detail-list-value">
                        @switch($student->course_type)
                            @case('liberal_arts')
                                文系
                                @break
                            @case('science')
                                理系
                                @break
                            @case('undecided')
                                未定
                                @break
                            @default
                                未設定
                        @endswitch
                    </div>
                </div> -->

                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">受験科目</div>
                    <div class="ui-detail-list-value">
                        @if (!empty($student->exam_subjects))
                            <div class="chip-list">
                                @foreach ($student->exam_subjects as $subject)
                                    <span class="chip">{{ $subject }}</span>
                                @endforeach
                            </div>
                        @else
                            未設定
                        @endif
                    </div>
                </div>

                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">志望校</div>
                    <div class="ui-detail-list-value">
                        @php
                            $schools = array_values(array_filter($student->desired_schools ?? [], fn ($v) => filled($v)));
                        @endphp

                        @if (!empty($schools))
                            <ul class="plain-list">
                                @foreach ($schools as $school)
                                    <li>{{ $school }}</li>
                                @endforeach
                            </ul>
                        @else
                            未設定
                        @endif
                    </div>
                </div>

                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">コンサル担当</div>
                    <div class="ui-detail-list-value">{{ $student->consultant?->name ?? '未設定' }}</div>
                </div>

                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">備考</div>
                    <div class="ui-detail-list-value">
                        {!! nl2br(e($student->note ?: '未設定')) !!}
                    </div>
                </div>
            </div>
        </section>

        <!-- <section class="ui-detail-section detail-card"> -->
        <section class="section-wrapper">
            <div class="page-header">
                <div>
                    <p class="page-eyebrow">Guidance Records</p>
                    <h1 class="page-title">学習記録</h1>
                </div>

                <div class="page-header-actions">
                    @can('view', $student)
                        <a href="{{ route('guidance-records.create', ['student_id' => $student->id]) }}" class="table-button table-button-register">
                            記録を追加
                        </a>
                    @endcan

                    <!-- @can('update', $student)
                        <a href="{{ route('students.edit', $student) }}" class="button button--secondary">
                            編集
                        </a>
                    @endcan -->
                </div>
            </div>

            @if ($records->isEmpty())
                <p class="text-muted">学習記録はまだありません。</p>
            @else
                @php
                    $week = ['(日)', '(月)', '(火)', '(水)', '(木)', '(金)', '(土)'];
                @endphp

                <div class="ui-record-list">
                    @foreach ($records as $record)
                        @php
                            $consultDate = $record->consulted_at?->format('Y/m/d');
                            $consultDayIndex = $record->consulted_at?->dayOfWeek;
                            $consultDay = !is_null($consultDayIndex) ? $week[$consultDayIndex] : '';
                            $consultTime = $record->consulted_at?->format('H:i');

                            $nextDate = $record->next_plan_date?->format('Y/m/d');
                            $nextDayIndex = $record->next_plan_date?->dayOfWeek;
                            $nextDay = !is_null($nextDayIndex) ? $week[$nextDayIndex] : '';
                            $nextTime = $record->next_plan_date?->format('H:i');
                        @endphp

                        <article class="ui-record-card">
                            <div class="ui-record-card__header">
                                <div class="ui-record-card__header-main">
                                    <h3 class="ui-record-card__title">
                                        実施日：
                                        @if ($record->consulted_at)
                                            {{ $consultDate }} {{ $consultDay }} {{ $consultTime }}
                                        @else
                                            実施日未設定
                                        @endif
                                    </h3>
                                    <p class="ui-record-card__meta">
                                        記録者: {{ $record->user->name ?? '未設定' }}
                                    </p>
                                </div>

                                <div class="ui-record-card-actions">
                                    <a href="{{ route('guidance-records.edit', $record) }}" class="table-button table-button-edit">編集</a>
                                    <a href="{{ route('guidance-records.pdf', $record) }}" target="_blank" class="table-button table-button-accent">
                                        PDF出力
                                    </a>
                                </div>
                            </div>

                            <div class="ui-record-card__body">
                                <div class="ui-record-grid">
                                    <section class="ui-record-block">
                                        <h4 class="ui-record-block__title">◎ 成長点</h4>
                                        <div class="ui-record-block__content">{!! nl2br(e($record->growth_point ?: '未入力')) !!}</div>
                                    </section>

                                    <section class="ui-record-block">
                                        <h4 class="ui-record-block__title">△ 課題点</h4>
                                        <div class="ui-record-block__content">{!! nl2br(e($record->challenge_point ?: '未入力')) !!}</div>
                                    </section>
                                </div>

                                <div class="ui-record-meta">
                                    <div class="ui-record-meta__item">
                                        <span class="ui-record-meta__label">自己評価</span>
                                        <span class="ui-record-meta__value">
                                            @if(!is_null($record->self_score))
                                                {{ $record->self_score }} / 100
                                            @else
                                                未入力
                                            @endif
                                        </span>
                                    </div>

                                    <div class="ui-record-meta__item">
                                        <span class="ui-record-meta__label">次回実施日</span>
                                        <span class="ui-record-meta__value">
                                            @if ($record->next_plan_date)
                                                {{ $nextDate }} {{ $nextDay }} {{ $nextTime }}
                                            @else
                                                未設定
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <section class="ui-record-block">
                                    <h4 class="ui-record-block__title">NOTE</h4>
                                    <div class="ui-record-block__content">{!! nl2br(e($record->note ?: '未入力')) !!}</div>
                                </section>

                                <div class="ui-record-subject-list">
                                    @if ($record->subject1_name || $record->subject1_detail)
                                        <section class="ui-record-block ui-record-block--subject">
                                            <h4 class="ui-record-block__title">科目① {{ $record->subject1_name ?: '未設定' }}</h4>
                                            <div class="ui-record-block__content">{!! nl2br(e($record->subject1_detail ?: '未入力')) !!}</div>
                                        </section>
                                    @endif

                                    @if ($record->subject2_name || $record->subject2_detail)
                                        <section class="ui-record-block ui-record-block--subject">
                                            <h4 class="ui-record-block__title">科目② {{ $record->subject2_name ?: '未設定' }}</h4>
                                            <div class="ui-record-block__content">{!! nl2br(e($record->subject2_detail ?: '未入力')) !!}</div>
                                        </section>
                                    @endif

                                    @if ($record->subject3_name || $record->subject3_detail)
                                        <section class="ui-record-block ui-record-block--subject">
                                            <h4 class="ui-record-block__title">科目③ {{ $record->subject3_name ?: '未設定' }}</h4>
                                            <div class="ui-record-block__content">{!! nl2br(e($record->subject3_detail ?: '未入力')) !!}</div>
                                        </section>
                                    @endif
                                </div>

                                <section class="ui-record-block">
                                    <h4 class="ui-record-block__title">その他</h4>
                                    <div class="ui-record-block__content">{!! nl2br(e($record->other_plan ?: '未入力')) !!}</div>
                                </section>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="pagination-wrap">
                    {{ $records->links() }}
                </div>
            @endif
        </section>
    </section>
@endsection