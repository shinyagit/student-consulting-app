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
                <a href="{{ route('teachers.edit', $teacher) }}" class="button button--secondary">編集</a>
            @endcan
        </div>

        <section class="detail-card">
            <h2 class="section-title">基本情報</h2>

            <div class="detail-list">
                <div class="detail-list__row">
                    <div class="detail-list__label">講師名</div>
                    <div class="detail-list__value">{{ $teacher->name }}</div>
                </div>

                <div class="detail-list__row">
                    <div class="detail-list__label">所属学部学科</div>
                    <div class="detail-list__value">{{ $teacher->department ?: '未設定' }}</div>
                </div>

                <div class="detail-list__row">
                    <div class="detail-list__label">学年</div>
                    <div class="detail-list__value">{{ $teacher->school_year ?: '未設定' }}</div>
                </div>

                <div class="detail-list__row">
                    <div class="detail-list__label">年齢</div>
                    <div class="detail-list__value">{{ $teacher->age ?: '未設定' }}</div>
                </div>

                <div class="detail-list__row">
                    <div class="detail-list__label">メール</div>
                    <div class="detail-list__value">{{ $teacher->email ?: '未設定' }}</div>
                </div>

                <div class="detail-list__row">
                    <div class="detail-list__label">ステータス</div>
                    <div class="detail-list__value">
                        @switch($teacher->status)
                            @case('active')
                                在籍中
                                @break
                            @case('inactive')
                                停止中
                                @break
                            @default
                                {{ $teacher->status }}
                        @endswitch
                    </div>
                </div>

                <div class="detail-list__row">
                    <div class="detail-list__label">備考</div>
                    <div class="detail-list__value">{{ $teacher->note ?: '未設定' }}</div>
                </div>
            </div>
        </section>

        <section class="detail-card">
            <h2 class="section-title">担当可能科目</h2>

            @if ($teacher->teacherSubjects->isEmpty())
                <p>担当可能科目は未設定です。</p>
            @else
                <div class="chip-list">
                    @foreach ($teacher->teacherSubjects as $teacherSubject)
                        <span class="chip">{{ $teacherSubject->subject }}</span>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="detail-card">
            <h2 class="section-title">担当生徒</h2>

            @if ($teacher->students->isEmpty())
                <p>担当生徒はまだ登録されていません。</p>
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
                                                {{ $student->status }}
                                        @endswitch
                                    </td>
                                    <td>
                                        <a href="{{ route('students.show', $student) }}">詳細</a>
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