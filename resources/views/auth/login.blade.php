@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
    <section class="auth-page">
        <div class="auth-card ui-detail-section">
            <div class="ui-form-section__header auth-card__header">
                <p class="ui-form-section__eyebrow">Authentication</p>
                <h1 class="ui-form-section__title auth-card-title">ログイン</h1>
            </div>

            <form method="POST" action="{{ url('/login') }}" class="ui-form auth-form">
                @csrf

                <section class="ui-form-section auth-form__section">
                    <div class="ui-form-grid">
                        <div class="ui-form-field ui-form-field--full">
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
                            @error('email')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="ui-form-field ui-form-field--full">
                            <label for="password" class="form-label">パスワード</label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-input"
                                required
                            >
                            @error('password')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="ui-form-field ui-form-field--full">
                            <label class="ui-check-row">
                                <input type="checkbox" name="remember" class="ui-check-row__input">
                                <span class="ui-check-row__label">ログイン状態を保持する</span>
                            </label>
                        </div>
                    </div>
                </section>

                <div class="form-actions-row auth-form__actions">
                    <button type="submit" class="auth-button auth-button-login">ログイン</button>
                </div>
            </form>
        </div>
    </section>
@endsection