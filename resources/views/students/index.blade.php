@extends('layouts.app')

@section('title', '生徒一覧')

@section('content')
    <section class="students-page">
        <div class="page-header">
            <div>
                <p class="page-eyebrow">Students</p>
                <h1 class="page-title">生徒一覧</h1>
                <p class="page-subtitle">受講生徒を一覧で確認できます。</p>
            </div>

            @can('create', \App\Models\Student::class)
                <a href="{{ route('students.create') }}" class="link-button link-button-register">生徒を登録する</a>
            @endcan
        </div>


        <form method="GET" action="{{ route('students.index') }}" class="ui-form ui-filter-form students-filter">
            <section class="ui-form-section ui-filter-form__section">
                <div class="ui-form-section-header">
                    <p class="ui-form-section-eyebrow">Student Filters</p>
                    <h2 class="ui-form-section-title">絞り込み</h2>
                </div>

                <div class="ui-form-grid">
                    <div class="ui-form-field">
                        <label for="keyword" class="form-label">生徒氏名</label>
                        <input
                            type="text"
                            name="keyword"
                            id="keyword"
                            class="form-input"
                            value="{{ request('keyword') }}"
                            placeholder="氏名で検索"
                        >
                    </div>

                    <div class="ui-form-field">
                        <label for="grade" class="form-label">学年</label>
                        <div class="form-select-wrap">
                            <select name="grade" id="grade" class="form-input">
                                <option value="">すべて</option>
                                @foreach (\App\Constants\GradeOptions::LIST as $grade)
                                    <option value="{{ $grade }}" @selected(request('grade') === $grade)>
                                        {{ $grade }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="ui-form-field">
                        <label for="status" class="form-label">ステータス</label>
                        <div class="form-select-wrap">
                            <select name="status" id="status" class="form-input">
                                <option value="">すべて</option>
                                <option value="active" @selected(request('status') === 'active')>在籍中</option>
                                <option value="leave" @selected(request('status') === 'leave')>休会</option>
                                <option value="graduated" @selected(request('status') === 'graduated')>卒業</option>
                                <option value="withdrawn" @selected(request('status') === 'withdrawn')>退塾</option>
                            </select>
                        </div>
                    </div>

                    <div class="ui-form-field">
                        <label for="course_type" class="form-label">文系理系</label>
                        <div class="form-select-wrap">
                            <select name="course_type" id="course_type" class="form-input">
                                <option value="">すべて</option>
                                <option value="liberal_arts" @selected(request('course_type') === 'liberal_arts')>文系</option>
                                <option value="science" @selected(request('course_type') === 'science')>理系</option>
                                <option value="undecided" @selected(request('course_type') === 'undecided')>未定</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-actions-row ui-filter-form-actions">
                    <button type="submit" class="link-button link-button-primary">検索</button>

                    @if (request()->filled('keyword') || request()->filled('grade') || request()->filled('status') || request()->filled('course_type'))
                        <a href="{{ route('students.index') }}" class="link-button link-button-cancel">リセット</a>
                    @endif
                </div>
            </section>
        </form>

        @if ($students->isEmpty())
            <div class="empty-state">
                <p>該当する生徒はいません。</p>
            </div>
        @else
            <section class="students-panel table-panel">
                <div class="table-wrap">
                    <table class="base-table students-table">
                        <thead>
                            <tr>
                                <th>生徒氏名</th>
                                <th>学年</th>
                                <th>学校名</th>
                                <th>ステータス</th>
                                <th>文系理系</th>
                                <th>志望校</th>
                                <th>コンサル担当</th>
                                <th>学習記録数</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                @php
                                    $schools = array_values(array_filter($student->desired_schools ?? [], fn ($v) => filled($v)));
                                @endphp

                                <tr>
                                    <td class="panel-table-name">{{ $student->name }}</td>
                                    <td>{{ $student->grade ?: '-' }}</td>
                                    <td>{{ $student->school_name ?: '-' }}</td>
                                    <td>
                                        @switch($student->status)
                                            @case('active')
                                                <span class="status-badge status-badge--active">在籍中</span>
                                                @break
                                            @case('leave')
                                                <span class="status-badge status-badge--leave">休会</span>
                                                @break
                                            @case('graduated')
                                                <span class="status-badge status-badge--graduated">卒業</span>
                                                @break
                                            @case('withdrawn')
                                                <span class="status-badge status-badge--withdrawn">退塾</span>
                                                @break
                                            @default
                                                <span class="text-muted">{{ $student->status }}</span>
                                        @endswitch
                                    </td>
                                    <td>
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
                                                <span class="text-muted">未設定</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @if (!empty($schools))
                                            <span>{{ $schools[0] }}</span>
                                            @if (count($schools) > 1)
                                                <span class="school-more-badge">＋{{ count($schools) - 1 }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted">未設定</span>
                                        @endif
                                    </td>
                                    <td>{{ $student->consultant?->name ?? '未設定' }}</td>
                                    <td>
                                        <span class="record-count-badge">{{ $student->guidance_records_count }}</span>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="{{ route('students.show', $student) }}" class="table-button table-button-detail">詳細</a>
                                            @can('update', $student)
                                                <a href="{{ route('students.edit', $student) }}" class="table-button table-button-edit">編集</a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination-nav">
                    {{ $students->links() }}
                </div>
            </section>
        @endif
    </section>
@endsection