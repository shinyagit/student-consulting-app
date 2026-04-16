@extends('layouts.app')

@section('title', '生徒編集')

@section('content')
    <h1>生徒編集</h1>

    <form method="POST" action="{{ route('students.update', $student) }}">
        @csrf
        @method('PUT')

        @include('students._form', ['student' => $student])

        <div style="margin-top: 24px;">
            <button type="submit">更新する</button>
        </div>
    </form>
@endsection