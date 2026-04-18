@extends('layouts.app')

@section('title', 'ユーザー編集')

@section('content')
    <section class="teachers-page">
        <div class="page-header">
            <div>
                <h1 class="page-title">ユーザー編集</h1>
                <p class="page-description">登録済みユーザーを編集します。</p>
            </div>
        </div>

        <form method="POST" action="{{ route('users.update', $user) }}" class="teacher-edit-form">
            @csrf
            @method('PUT')

            @include('users._form', ['user' => $user])

            <div class="form-actions">
                <button type="submit" class="confirm-button confirm-button-register">更新する</button>
            </div>
        </form>
    </section>
@endsection