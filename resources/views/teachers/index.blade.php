@extends('layouts.app')

@section('title', '講師一覧')

@section('content')
    <section class="teachers-page">
        <div class="page-header">
            <div>
                <p class="page-eyebrow">Teachers</p>
                <h1 class="page-title">講師一覧</h1>
            </div>

            @can('create', \App\Models\Teacher::class)
                <a href="{{ route('teachers.create') }}" class="link-button">講師を登録する</a>
            @endcan
        </div>

        @if ($teachers->isEmpty())
            <div class="empty-state">
                <p>講師はまだ登録されていません。</p>
            </div>
        @else
            <section class="teachers-panel">
                <div class="table-wrap">
                    <table class="base-table teachers-table">
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
                                    <td class="teachers-table__name">{{ $teacher->name }}</td>
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
                                        <div class="teachers-table__actions">
                                            <a href="{{ route('teachers.show', $teacher) }}" class="link-button">詳細</a>

                                            @can('update', $teacher)
                                                <a href="{{ route('teachers.edit', $teacher) }}" class="link-button link-button--soft">編集</a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination-nav">
                    {{ $teachers->links() }}
                </div>
            </section>
        @endif
    </section>
@endsection