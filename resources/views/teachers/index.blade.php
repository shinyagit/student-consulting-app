@extends('layouts.app')

@section('title', '講師一覧')

@section('content')
    <section class="teachers-page">
        <div class="page-header">
            <div>
                <p class="page-eyebrow">Teachers</p>
                <h1 class="page-title">講師一覧</h1>
                <p class="page-subtitle">指導講師を一覧で確認できます。</p>
            </div>

            @can('create', \App\Models\Teacher::class)
                <a href="{{ route('teachers.create') }}" class="link-button link-button-register">講師を登録する</a>
            @endcan
        </div>

        <form method="GET" action="{{ route('teachers.index') }}" class="ui-form ui-filter-form teachers-filter">
            <section class="ui-form-section ui-filter-form__section">
                <div class="ui-form-section-header">
                    <p class="ui-form-section-eyebrow">Teacher Filters</p>
                    <h2 class="ui-form-section-title">絞り込み</h2>
                </div>

                <div class="ui-form-grid">
                    <div class="ui-form-field">
                        <label for="keyword" class="form-label">講師名</label>
                        <input
                            type="text"
                            name="keyword"
                            id="keyword"
                            class="form-input"
                            value="{{ request('keyword') }}"
                            placeholder="講師名で検索"
                        >
                    </div>

                    <div class="ui-form-field">
                        <label for="status" class="form-label">ステータス</label>
                        <div class="form-select-wrap">
                            <select name="status" id="status" class="form-input">
                                <option value="">すべて</option>
                                <option value="active" @selected(request('status') === 'active')>在籍中</option>
                                <option value="inactive" @selected(request('status') === 'inactive')>停止中</option>
                            </select>
                        </div>
                    </div>

                    <div class="ui-form-field">
                        <label for="department" class="form-label">所属学部学科</label>
                        <input
                            type="text"
                            name="department"
                            id="department"
                            class="form-input"
                            value="{{ request('department') }}"
                            placeholder="所属で検索"
                        >
                    </div>

                    <div class="ui-form-field">
                        <label for="subject" class="form-label">担当可能科目</label>
                        <div class="form-select-wrap">
                            <select name="subject" id="subject" class="form-input">
                                <option value="">すべて</option>
                                @foreach (\App\Constants\SubjectOptions::LIST as $subject)
                                    <option value="{{ $subject }}" @selected(request('subject') === $subject)>
                                        {{ $subject }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-actions-row ui-filter-form-actions">
                    <button type="submit" class="link-button link-button-primary">検索</button>

                    @if (
                        request()->filled('keyword') ||
                        request()->filled('status') ||
                        request()->filled('department') ||
                        request()->filled('subject')
                    )
                        <a href="{{ route('teachers.index') }}" class="link-button link-button-cancel">リセット</a>
                    @endif
                </div>
            </section>
        </form>


        @if ($teachers->isEmpty())
            <div class="empty-state">
                <p>講師はまだ登録されていません。</p>
            </div>
        @else
            <section class="table-panel">
                <div class="table-wrap">
                    <table class="base-table">
                        <thead>
                            <tr>
                                <th>講師名</th>
                                <th>学部</th>
                                <th>学年</th>
                                <th>ステータス</th>
                                <th>担当生徒数</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teachers as $teacher)
                                <tr>
                                    <td class="panel-table-name teacher-name"><a href="{{ route('teachers.show', $teacher) }}">{{ $teacher->name }}</a></td>
                                    <td>{{ $teacher->department ?: '-' }}</td>
                                    <td>{{ $teacher->school_year ?: '-' }}</td>
                                    <td>
                                        @switch($teacher->status)
                                            @case('active')
                                                <span class="status-badge status-badge--active">在籍中</span>
                                                @break
                                            @case('inactive')
                                                <span class="status-badge status-badge--withdrawn">停止中</span>
                                                @break
                                            @default
                                                <span class="text-muted">{{ $teacher->status ?: '未設定' }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <span class="record-count-badge">{{ $teacher->students_count }}</span>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="{{ route('teachers.show', $teacher) }}" class="table-button table-button-detail">詳細</a>

                                            @can('update', $teacher)
                                                <a href="{{ route('teachers.edit', $teacher) }}" class="table-button table-button-edit">編集</a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination-nav">
                    {{ $teachers->links('vendor.pagination.custom') }}
                </div>
            </section>
        @endif
    </section>
@endsection