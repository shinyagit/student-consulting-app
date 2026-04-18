@extends('layouts.app')

@section('title', 'ユーザー登録')

@section('content')
    <section class="teachers-page">
        <div class="page-header">
            <div>
                <h1 class="page-title">ユーザー登録</h1>
                <p class="page-description">アプリ利用者を追加します。</p>
            </div>
        </div>

        <form method="POST" action="{{ route('users.store') }}" class="teacher-edit-form">
            @csrf

            @include('users._form')

            <div class="form-actions">
                <button type="submit" class="confirm-button confirm-button-register">登録する</button>
            </div>
        </form>
    </section>
@endsection