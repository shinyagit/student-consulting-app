@extends('layouts.app')

@section('title', '講師詳細')

@section('content')
    <section class="teachers-page">
        <div class="page-header">
            <div>
                <p class="page-eyebrow">Teachers</p>
                <h1 class="page-title">講師詳細</h1>
            </div>

            @can('update', $teacher)
                <a href="{{ route('teachers.edit', $teacher) }}" class="link-button link-button-edit">編集</a>
            @endcan
        </div>

        <section class="ui-detail-section detail-card">
            <div class="ui-detail-section-header">
                <p class="ui-detail-section-eyebrow">Teacher Profile</p>
                <h2 class="ui-detail-section-title">基本情報</h2>
            </div>

            <div class="ui-detail-list">
                <!-- <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">講師コード</div>
                    <div class="ui-detail-list-value">{{ $teacher->teacher_code ?: '未設定' }}</div>
                </div> -->

                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">講師名</div>
                    <div class="ui-detail-list-value">{{ $teacher->name }}</div>
                </div>

                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">所属学部学科 / 学年</div>
                    <div class="ui-detail-list-value">{{ $teacher->department ?: '未設定' }} / {{ $teacher->school_year ?: '未設定' }}</div>
                </div>

                <!-- <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">学年</div>
                    <div class="ui-detail-list-value">{{ $teacher->school_year ?: '未設定' }}</div>
                </div> -->

                <!-- <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">年齢</div>
                    <div class="ui-detail-list-value">{{ $teacher->age ?: '未設定' }}</div>
                </div> -->

                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">ステータス</div>
                    <div class="ui-detail-list-value">
                        @switch($teacher->status)
                            @case('active')
                                <span class="ui-status-chip ui-status-chip--primary">在籍中</span>
                                @break
                            @case('inactive')
                                <span class="ui-status-chip ui-status-chip--muted">停止中</span>
                                @break
                            @default
                                {{ $teacher->status ?: '未設定' }}
                        @endswitch
                    </div>
                </div>

                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">備考</div>
                    <div class="ui-detail-list-value">
                        {!! nl2br(e($teacher->note ?: '未設定')) !!}
                    </div>
                </div>
            </div>
        </section>

        <section class="ui-detail-section detail-card">
            <div class="ui-detail-section-header">
                <p class="ui-detail-section-eyebrow">Available Subjects</p>
                <h2 class="ui-detail-section-title">担当可能科目</h2>
            </div>

            @if ($teacher->teacherSubjects->isEmpty())
                <p class="text-muted">担当可能科目は未設定です。</p>
            @else
                <div class="chip-list">
                    @foreach ($teacher->teacherSubjects as $teacherSubject)
                        <span class="chip">{{ $teacherSubject->subject }}</span>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="ui-detail-section detail-card">
            <div class="ui-detail-section-header">
                <p class="ui-detail-section-eyebrow">Assigned Students</p>
                <h2 class="ui-detail-section-title">担当生徒</h2>
            </div>

            @if ($teacher->students->isEmpty())
                <p class="text-muted">担当生徒はまだ登録されていません。</p>
            @else
                <div class="table-wrap">
                    <table class="base-table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>生徒氏名</th>
                                <th>学校名</th>
                                <th>学年</th>
                                <th>ステータス</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teacher->students as $student)
                                <tr>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->school_name ?: '未設定' }}</td>
                                    <td>{{ $student->grade ?: '未設定' }}</td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <a href="{{ route('students.show', $student) }}" class="table-button table-button-detail">詳細</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </section>
@endsection