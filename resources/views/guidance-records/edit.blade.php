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

        <div class="detail-card">
            <p><strong>生徒名:</strong> {{ $student->name }}</p>
            <p><strong>学校名:</strong> {{ $student->school_name }}</p>
            <p><strong>学年:</strong> {{ $student->grade }}</p>
        </div>

        <form method="POST" action="{{ route('guidance-records.update', $record) }}" class="guidance-edit-form">
            @csrf
            @method('PUT')
            @include('guidance-records._form', ['student' => $student, 'record' => $record])
            <div class="form-actions-row">
                <button type="submit" class="button button--primary">更新する</button>
            </div>
        </form>
    </section>
@endsection