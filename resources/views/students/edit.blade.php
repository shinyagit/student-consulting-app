@extends('layouts.app')

@section('title', '生徒編集')

@section('content')
    <div class="page-header">
        <div>
            <p class="page-eyebrow">Student Info Setting</p>
            <h1 class="page-title">生徒情報編集</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('students.update', $student) }}">
        @csrf
        @method('PUT')

        @include('students._form', ['student' => $student])

        <div>
            <button type="submit" class="confirm-button confirm-button-register">更新する</button>
        </div>
    </form>
@endsection