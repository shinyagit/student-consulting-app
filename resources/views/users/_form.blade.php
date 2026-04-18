<div class="ui-form">
    <section class="ui-form-section">
        <div class="ui-form-section-header">
            <p class="ui-form-section-eyebrow">User Information</p>
            <h3 class="ui-form-section-title">ユーザー情報</h3>
        </div>

        <div class="ui-form-grid">
            <div class="ui-form-field">
                <label for="name" class="form-label">氏名</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-input"
                    value="{{ old('name', $user->name ?? '') }}"
                    required
                >
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="ui-form-field">
                <label for="email" class="form-label">メールアドレス</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-input"
                    value="{{ old('email', $user->email ?? '') }}"
                    required
                >
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="ui-form-field">
                <label for="password" class="form-label">
                    パスワード
                    @isset($user)
                        <span class="form-help">変更しない場合は空欄</span>
                    @endisset
                </label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-input"
                    @empty($user) required @endempty
                >
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="ui-form-field">
                <label for="password_confirmation" class="form-label">パスワード確認</label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="form-input"
                    @empty($user) required @endempty
                >
            </div>

            <div class="ui-form-field">
                <label for="role" class="form-label">権限</label>
                <select name="role" id="role" class="form-input" required>
                    <option value="admin" @selected(old('role', $user->role ?? 'staff') === 'admin')>admin</option>
                    <option value="staff" @selected(old('role', $user->role ?? 'staff') === 'staff')>staff</option>
                </select>
                @error('role')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>
</div>