@extends('layouts.app')

@section('title', 'ユーザー一覧')

@section('content')
    <section class="teachers-page">
        <div class="page-header">
            <div>
                <p class="page-eyebrow">Users</p>
                <h1 class="page-title">管理者・スタッフ一覧</h1>
                <p class="page-subtitle">コンサルティング担当を一覧で確認できます。</p>
            </div>

            <a href="{{ route('users.create') }}" class="link-button link-button-register">ユーザーを登録する</a>
        </div>


        @if ($users->isEmpty())
            <div class="empty-state">
                <p>ユーザーはまだ登録されていません。</p>
            </div>
        @else
            <section class="teachers-panel table-panel">
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
                                        <div class="teachers-table-actions">
                                            <a href="{{ route('users.edit', $user) }}" class="table-button table-button-edit">編集</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination-nav">
                    {{ $users->links() }}
                </div>
            </section>
        @endif
    </section>
@endsection