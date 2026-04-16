@extends('layouts.app')

@section('title', '生徒登録')

@section('content')
    <h1>生徒登録</h1>

    <form method="POST" action="{{ route('students.store') }}">
        @csrf

        @include('students._form')

        <div style="margin-top: 24px;">
            <button type="submit">登録する</button>
        </div>
    </form>
@endsection