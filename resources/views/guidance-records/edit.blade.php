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

        <section class="ui-detail-section detail-card">
            <div class="ui-detail-section-header">
                <p class="ui-detail-section-eyebrow">Student Information</p>
                <h2 class="ui-detail-section-title">対象生徒</h2>
            </div>

            <div class="ui-detail-list">
                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">生徒名</div>
                    <div class="ui-detail-list-value">{{ $student->name }}</div>
                </div>

                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">学校名</div>
                    <div class="ui-detail-list-value">{{ $student->school_name ?: '未設定' }}</div>
                </div>

                <div class="ui-detail-list-row">
                    <div class="ui-detail-list__label">学年</div>
                    <div class="ui-detail-list-value">{{ $student->grade ?: '未設定' }}</div>
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