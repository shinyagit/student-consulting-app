@php
    $subjectOptions = \App\Constants\SubjectOptions::LIST;

    $selectedSubjects = old(
        'available_subjects',
        isset($teacher) ? $teacher->teacherSubjects->pluck('subject')->toArray() : []
    );
@endphp

<div class="ui-form">
    <section class="ui-form-section">
        <div class="ui-form-section-header">
            <p class="ui-form-section-eyebrow">Basic Information</p>
            <h3 class="ui-form-section-title">基本情報</h3>
        </div>

        <div class="ui-form-grid">
            <div class="ui-form-field">
                <label for="teacher_code" class="form-label">講師コード</label>
                <input
                    type="text"
                    name="teacher_code"
                    id="teacher_code"
                    class="form-input"
                    value="{{ old('teacher_code', $teacher->teacher_code ?? '') }}"
                    @if(isset($teacher)) readonly @endif
                    required
                >
                @error('teacher_code')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="ui-form-field">
                <label for="name" class="form-label">講師名</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-input"
                    value="{{ old('name', $teacher->name ?? '') }}"
                    required
                >
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="ui-form-field">
                <label for="department" class="form-label">所属学部学科</label>
                <input
                    type="text"
                    name="department"
                    id="department"
                    class="form-input"
                    value="{{ old('department', $teacher->department ?? '') }}"
                >
                @error('department')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="ui-form-field">
                <label for="school_year" class="form-label">学年</label>
                <input
                    type="text"
                    name="school_year"
                    id="school_year"
                    class="form-input"
                    value="{{ old('school_year', $teacher->school_year ?? '') }}"
                >
                @error('school_year')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="ui-form-field">
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
                @error('age')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="ui-form-field">
                <label for="status" class="form-label">ステータス</label>
                <select name="status" id="status" class="form-input" required>
                    <option value="active" @selected(old('status', $teacher->status ?? 'active') === 'active')>在籍中</option>
                    <option value="inactive" @selected(old('status', $teacher->status ?? '') === 'inactive')>停止中</option>
                </select>
                @error('status')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <section class="ui-form-section">
        <div class="ui-form-section-header">
            <p class="ui-form-section-eyebrow">Available Subjects</p>
            <h3 class="ui-form-section-title">担当可能科目</h3>
        </div>

        <div class="ui-form-grid">
            <div class="ui-form-field ui-form-field--full">
                <!-- <label class="form-label">担当可能科目</label> -->
                <div class="ui-selection-panel">
                    <div class="ui-checkbox-grid">
                        @foreach ($subjectOptions as $subject)
                            <label class="ui-checkbox-tile">
                                <input
                                    type="checkbox"
                                    name="available_subjects[]"
                                    value="{{ $subject }}"
                                    @checked(in_array($subject, $selectedSubjects, true))
                                >
                                <span>{{ $subject }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                @error('available_subjects')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                @error('available_subjects.*')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <section class="ui-form-section">
        <div class="ui-form-section-header">
            <p class="ui-form-section-eyebrow">Notes</p>
            <h3 class="ui-form-section-title">備考</h3>
        </div>

        <div class="ui-form-grid">
            <div class="ui-form-field ui-form-field--full">
                <!-- <label for="note" class="form-label">備考</label> -->
                <textarea
                    name="note"
                    id="note"
                    rows="4"
                    class="form-input"
                >{{ old('note', $teacher->note ?? '') }}</textarea>
                @error('note')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>
</div>