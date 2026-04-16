@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
    <section class="auth-page">
        <div class="auth-card">
            <h1 class="auth-card__title">ログイン</h1>

            <form method="POST" action="{{ url('/login') }}" class="auth-form">
                @csrf

                <div class="form-grid">
                    <div class="form-field">
                        <label for="email" class="form-label">メールアドレス</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-input"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >
                    </div>

                    <div class="form-field">
                        <label for="password" class="form-label">パスワード</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-input"
                            required
                        >
                    </div>

                    <div class="form-check">
                        <label class="form-check__label">
                            <input type="checkbox" name="remember" class="form-check__input">
                            <span>ログイン状態を保持する</span>
                        </label>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="button button--primary">ログイン</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection