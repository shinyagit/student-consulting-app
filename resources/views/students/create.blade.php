@extends('layouts.app')

@section('title', '生徒登録')

@section('content')
    <div class="page-header">
        <div>
            <p class="page-eyebrow">Student Info Register</p>
            <h1 class="page-title">生徒情報登録</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('students.store') }}">
        @csrf

        @include('students._form')

        <div>
            <button type="submit" class="confirm-button confirm-button-register">登録する</button>
        </div>
    </form>
@endsection