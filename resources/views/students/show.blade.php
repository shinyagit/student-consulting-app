@extends('layouts.app')

@section('title', '生徒詳細')

@section('content')
    <section class="students-page">
        <div class="page-header">
            <div>
                <p class="page-eyebrow">Students</p>
                <h1 class="page-title">生徒詳細</h1>
            </div>

            <div class="page-header__actions">
                @can('view', $student)
                    <a href="{{ route('guidance-records.create', ['student_id' => $student->id]) }}" class="button">
                        記録を追加
                    </a>
                @endcan

                @can('update', $student)
                    <a href="{{ route('students.edit', $student) }}" class="button button--secondary">
                        編集
                    </a>
                @endcan
            </div>
        </div>

        <section class="detail-card">
            <h2 class="section-title">基本情報</h2>

            <div class="detail-list">
                <div class="detail-list__row">
                    <div class="detail-list__label">生徒氏名</div>
                    <div class="detail-list__value">{{ $student->name }}</div>
                </div>

                <div class="detail-list__row">
                    <div class="detail-list__label">生徒氏名ふりがな</div>
                    <div class="detail-list__value">{{ $student->name_kana ?: '未設定' }}</div>
                </div>

                <div class="detail-list__row">
                    <div class="detail-list__label">学校名</div>
                    <div class="detail-list__value">{{ $student->school_name ?: '未設定' }}</div>
                </div>

                <div class="detail-list__row">
                    <div class="detail-list__label">学年</div>
                    <div class="detail-list__value">{{ $student->grade ?: '未設定' }}</div>
                </div>

                <div class="detail-list__row">
                    <div class="detail-list__label">ステータス</div>
                    <div class="detail-list__value">
                        @switch($student->status)
                            @case('active')
                                在籍中
                                @break
                            @case('leave')
                                休会
                                @break
                            @case('graduated')
                                卒業
                                @break
                            @case('withdrawn')
                                退塾
                                @break
                            @default
                                {{ $student->status ?: '未設定' }}
                        @endswitch
                    </div>
                </div>

                <div class="detail-list__row">
                    <div class="detail-list__label">文系理系</div>
                    <div class="detail-list__value">
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

                <div class="detail-list__row">
                    <div class="detail-list__label">受験科目</div>
                    <div class="detail-list__value">
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

                <div class="detail-list__row">
                    <div class="detail-list__label">志望校</div>
                    <div class="detail-list__value">
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

                <div class="detail-list__item">
                    <div class="detail-list__label">コンサル担当</div>
                    <div class="detail-list__value">{{ $student->consultant?->name ?? '未設定' }}</div>
                </div>

                <div class="detail-list__row">
                    <div class="detail-list__label">備考</div>
                    <div class="detail-list__value">
                        {!! nl2br(e($student->note ?: '未設定')) !!}
                    </div>
                </div>
            </div>
        </section>

        <section class="detail-card">
            <h2 class="section-title">担当講師</h2>

            @if ($student->teachers->isEmpty())
                <p>担当講師は未設定です。</p>
            @else
                <div class="teacher-list">
                    @foreach ($student->teachers as $teacher)
                        @php
                            $assignedSubjects = $student->studentTeacherSubjects
                                ->where('teacher_id', $teacher->id)
                                ->pluck('subject')
                                ->values()
                                ->all();
                        @endphp

                        <div class="teacher-list__item">
                            <div class="teacher-list__main">
                                <div class="teacher-list__name">{{ $teacher->name }}</div>

                                @if ($teacher->department || $teacher->school_year)
                                    <div class="form-help">
                                        {{ $teacher->department ?: '所属未設定' }}
                                        @if ($teacher->school_year)
                                            / {{ $teacher->school_year }}
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="teacher-list__subjects">
                                @if (!empty($assignedSubjects))
                                    <div class="chip-list">
                                        @foreach ($assignedSubjects as $subject)
                                            <span class="chip">{{ $subject }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">担当科目未設定</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="detail-card">
            <h2 class="section-title">学習記録</h2>

            @if ($records->isEmpty())
                <p>学習記録はまだありません。</p>
            @else
                @php
                    $week = ['(日)', '(月)', '(火)', '(水)', '(木)', '(金)', '(土)'];
                @endphp

                <div class="record-card-list">
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

                        <article class="record-card">
                            <div class="record-card__header">
                                <div>
                                    <h3 class="record-card__title">
                                        @if ($record->consulted_at)
                                            {{ $consultDate }} {{ $consultDay }} {{ $consultTime }}
                                        @else
                                            実施日未設定
                                        @endif
                                    </h3>
                                    <p class="record-card__teacher">
                                        記録者: {{ $record->user->name ?? '未設定' }}
                                    </p>
                                </div>

                                <div class="record-card__actions">
                                    <a href="{{ route('guidance-records.edit', $record) }}" class="link-button">編集</a>
                                    <a href="{{ route('guidance-records.pdf', $record) }}" target="_blank" class="link-button link-button--soft">
                                        PDF出力
                                    </a>
                                </div>
                            </div>

                            <div class="record-card__body">
                                <div class="record-grid">
                                    <div class="record-block">
                                        <h4 class="record-block__title">成長点</h4>
                                        <div class="record-block__content">{!! nl2br(e($record->growth_point ?: '未入力')) !!}</div>
                                    </div>

                                    <div class="record-block">
                                        <h4 class="record-block__title">課題点</h4>
                                        <div class="record-block__content">{!! nl2br(e($record->challenge_point ?: '未入力')) !!}</div>
                                    </div>
                                </div>

                                <div class="record-meta">
                                    <div class="record-meta__item">
                                        <span class="record-meta__label">自己評価</span>
                                        <span class="record-meta__value">
                                            @if(!is_null($record->self_score))
                                                {{ $record->self_score }} / 100
                                            @else
                                                未入力
                                            @endif
                                        </span>
                                    </div>

                                    <div class="record-meta__item">
                                        <span class="record-meta__label">次回実施日</span>
                                        <span class="record-meta__value">
                                            @if ($record->next_plan_date)
                                                {{ $nextDate }} {{ $nextDay }} {{ $nextTime }}
                                            @else
                                                未設定
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="record-block">
                                    <h4 class="record-block__title">NOTE</h4>
                                    <div class="record-block__content">{!! nl2br(e($record->note ?: '未入力')) !!}</div>
                                </div>

                                <div class="record-subjects">
                                    @if ($record->subject1_name || $record->subject1_detail)
                                        <div class="record-subject">
                                            <h4 class="record-subject__title">科目① {{ $record->subject1_name ?: '未設定' }}</h4>
                                            <div class="record-subject__content">{!! nl2br(e($record->subject1_detail ?: '未入力')) !!}</div>
                                        </div>
                                    @endif

                                    @if ($record->subject2_name || $record->subject2_detail)
                                        <div class="record-subject">
                                            <h4 class="record-subject__title">科目② {{ $record->subject2_name ?: '未設定' }}</h4>
                                            <div class="record-subject__content">{!! nl2br(e($record->subject2_detail ?: '未入力')) !!}</div>
                                        </div>
                                    @endif

                                    @if ($record->subject3_name || $record->subject3_detail)
                                        <div class="record-subject">
                                            <h4 class="record-subject__title">科目③ {{ $record->subject3_name ?: '未設定' }}</h4>
                                            <div class="record-subject__content">{!! nl2br(e($record->subject3_detail ?: '未入力')) !!}</div>
                                        </div>
                                    @endif
                                </div>

                                <div class="record-block">
                                    <h4 class="record-block__title">その他</h4>
                                    <div class="record-block__content">{!! nl2br(e($record->other_plan ?: '未入力')) !!}</div>
                                </div>
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