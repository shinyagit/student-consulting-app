@extends('layouts.app')

@section('title', '講師編集')

@section('content')
    <section class="teachers-page">
        <div class="page-header">
            <div>
                <p class="page-eyebrow">Teachers</p>
                <h1 class="page-title">講師編集</h1>
            </div>
        </div>

        <form method="POST" action="{{ route('teachers.update', $teacher) }}" class="teacher-edit-form">
            @csrf
            @method('PUT')

            @include('teachers._form', ['teacher' => $teacher])

            <div class="form-actions-row">
                <button type="submit" class="button button--primary">更新する</button>
            </div>
        </form>
    </section>
@endsection