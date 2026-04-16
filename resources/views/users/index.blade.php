@extends('layouts.app')

@section('title', 'ユーザー一覧')

@section('content')
    <section class="teachers-page">
        <div class="page-header">
            <div>
                <h1 class="page-title">ユーザー一覧</h1>
                <p class="page-description">アプリにログインできる利用者を管理します。</p>
            </div>

            <a href="{{ route('users.create') }}" class="link-button">ユーザーを登録する</a>
        </div>

        @if ($users->isEmpty())
            <div class="empty-state">
                <p>ユーザーはまだ登録されていません。</p>
            </div>
        @else
            <section class="teachers-panel">
                <div class="table-wrap">
                    <table class="base-table teachers-table">
                        <thead>
                            <tr>
                                <th>氏名</th>
                                <th>メールアドレス</th>
                                <th>権限</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="teachers-table__name">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <div class="teachers-table__actions">
                                            <a href="{{ route('users.edit', $user) }}" class="link-button link-button--soft">編集</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="teachers-pagination">
                    {{ $users->links() }}
                </div>
            </section>
        @endif
    </section>
@endsection