<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '広大研コンサルティング')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=LINE+Seed+JP&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+2:wght@100..900&display=swap" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="app-shell">
        <header class="app-header">
            <div class="app-header__inner">
                <div class="app-brand">
                    <a href="{{ route('dashboard') }}" class="app-brand__logo">
                        広大研 自習コンサルティング
                    </a>
                </div>

                <nav class="app-nav">
                    <a href="{{ route('dashboard') }}" class="app-nav__link">ダッシュボード</a>

                    @auth
                        <a href="{{ route('students.index') }}" class="app-nav__link">生徒一覧</a>
                        <a href="{{ route('teachers.index') }}" class="app-nav__link">講師一覧</a>
                    @endauth
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('users.index') }}" class="app-nav__link">ユーザー管理</a>
                        @endif
                    @endauth
                </nav>

                <div class="app-user">
                    @auth
                        <div class="app-user__meta">
                            <span class="app-user__name">{{ auth()->user()->name }}</span>
                            <span class="app-user__role">
                                @if(auth()->user()->role === 'admin')
                                    管理者
                                @elseif(auth()->user()->role === 'teacher')
                                    講師
                                @else
                                    {{ auth()->user()->role }}
                                @endif
                            </span>
                        </div>

                        <form method="POST" action="{{ url('/logout') }}" class="app-user__logout">
                            @csrf
                            <button type="submit" class="button button--soft">ログアウト</button>
                        </form>
                    @else
                        <a href="{{ url('/login') }}" class="button button--primary">ログイン</a>
                    @endauth
                </div>
            </div>
        </header>

        <main class="app-main">
            <div class="app-container">
                @if (session('success'))
                    <div class="flash-message flash-message--success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="flash-message flash-message--error">
                        <ul class="flash-message__list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>