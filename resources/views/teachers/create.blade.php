@extends('layouts.app')

@section('title', '講師登録')

@section('content')
    <section class="teachers-page">
        <div class="page-header">
            <div>
                <p class="page-eyebrow">Teachers</p>
                <h1 class="page-title">講師登録</h1>
            </div>
        </div>

        <form method="POST" action="{{ route('teachers.store') }}" class="teacher-edit-form">
            @csrf

            @include('teachers._form')

            <div class="form-actions-row">
                <button type="submit" class="button button--primary">登録する</button>
            </div>
        </form>
    </section>
@endsection