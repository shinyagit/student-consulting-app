@php
    $subjectOptions = \App\Support\SubjectOptions::LIST;

    $selectedSubjects = old(
        'available_subjects',
        isset($teacher) ? $teacher->teacherSubjects->pluck('subject')->toArray() : []
    );
@endphp

<div class="teacher-form">
    <div class="teacher-form__grid">
        <div class="form-field">
            <label for="name" class="form-label">講師名</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-input"
                value="{{ old('name', $teacher->name ?? '') }}"
                required
            >
        </div>

        <div class="form-field">
            <label for="department" class="form-label">所属学部学科</label>
            <input
                type="text"
                name="department"
                id="department"
                class="form-input"
                value="{{ old('department', $teacher->department ?? '') }}"
            >
        </div>

        <div class="form-field">
            <label for="school_year" class="form-label">学年</label>
            <input
                type="text"
                name="school_year"
                id="school_year"
                class="form-input"
                value="{{ old('school_year', $teacher->school_year ?? '') }}"
            >
        </div>

        <div class="form-field">
            <label for="age" class="form-label">年齢</label>
            <input
                type="number"
                name="age"
                id="age"
                class="form-input"
                value="{{ old('age', $teacher->age ?? '') }}"
                min="18"
                max="99"
            >
        </div>

        <div class="form-field">
            <label for="email" class="form-label">メールアドレス</label>
            <input
                type="email"
                name="email"
                id="email"
                class="form-input"
                value="{{ old('email', $teacher->email ?? '') }}"
            >
        </div>

        <div class="form-field">
            <label for="status" class="form-label">ステータス</label>
            <select name="status" id="status" class="form-input" required>
                <option value="active" @selected(old('status', $teacher->status ?? 'active') === 'active')>在籍中</option>
                <option value="inactive" @selected(old('status', $teacher->status ?? '') === 'inactive')>停止中</option>
            </select>
        </div>
    </div>

    <div class="teacher-form__section">
        <div class="section-heading">
            <p class="section-heading__eyebrow">Available Subjects</p>
            <h3 class="section-heading__title">担当可能科目</h3>
        </div>

        <div class="subject-check-grid">
            @foreach ($subjectOptions as $subject)
                <label class="subject-check">
                    <input
                        type="checkbox"
                        name="available_subjects[]"
                        value="{{ $subject }}"
                        class="subject-check__input"
                        @checked(in_array($subject, $selectedSubjects, true))
                    >
                    <span class="subject-check__label">{{ $subject }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="teacher-form__section">
        <div class="form-field">
            <label for="note" class="form-label">備考</label>
            <textarea
                name="note"
                id="note"
                rows="4"
                class="form-input"
            >{{ old('note', $teacher->note ?? '') }}</textarea>
        </div>
    </div>
</div>