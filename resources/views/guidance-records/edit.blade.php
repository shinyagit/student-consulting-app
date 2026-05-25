@extends('layouts.app')

@section('title', '学習記録編集')

@section('content')
    <section class="guidance-page">
        <div class="page-header">
            <div>
                <p class="page-eyebrow">Guidance Record</p>
                <h1 class="page-title">学習記録編集</h1>
            </div>
        </div>

        @php
            $courseTypeLabel = match ($student->course_type ?? null) {
                'liberal_arts' => '文系',
                'science' => '理系',
                'undecided' => '未定',
                default => '未設定',
            };
            $schools = array_values(array_filter($student->desired_schools ?? [], fn ($v) => filled($v)));
        @endphp

        <section class="ui-detail-section detail-card">
            <div class="ui-detail-section-header">
                <p class="ui-detail-section-eyebrow">Student Information</p>
                <h2 class="ui-detail-section-title">対象生徒</h2>
            </div>

            <div class="ui-detail-list">
                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">生徒名</div>
                    <div class="ui-detail-list-value">{{ $student->name }}（{{ $student->name_kana }}）</div>
                </div>

                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">学校名 / 学年 / 文理選択</div>
                    <div class="ui-detail-list-value">
                        {{ $student->school_name ?: '未設定' }} / {{ $student->grade ?: '未設定' }}
                        @switch($student->course_type)
                            @case('liberal_arts')
                                 / <span class="ui-course-chip ui-course-chip--liberal-arts">文系</span>
                                @break
                            @case('science')
                                 / <span class="ui-course-chip ui-course-chip--science">理系</span>
                                @break
                            @case('undecided')
                                 / <span class="ui-course-chip ui-course-chip--other">未定</span>
                                @break
                            @default
                                 / <span class="ui-course-chip ui-course-chip--muted">未設定</span>
                        @endswitch
                    </div>
                </div>

                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">志望校</div>
                    <div class="ui-detail-list-value">
                        @foreach ($schools as $school)
                            <p>{{ $school ?: '未設定' }}</p>
                        @endforeach
                    </div>
                    
                </div>
            </div>
        </section>

        <form method="POST" action="{{ route('guidance-records.update', $record) }}" class="guidance-edit-form">
            @csrf
            @method('PUT')

            @include('guidance-records._form', ['student' => $student, 'record' => $record])

            <div class="form-actions-row">
                <button type="submit" class="link-button link-button-register">更新する</button>
            </div>
        </form>
    </section>
@endsection