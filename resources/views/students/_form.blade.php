@php
    $subjectOptions = [
        '英語',
        '国語',
        '数学IA',
        '数学IIBC',
        '数学III',
        '生物',
        '物理',
        '化学',
        '地学',
        '生物基礎',
        '物理基礎',
        '化学基礎',
        '地学基礎',
        '日本史',
        '世界史',
        '地理',
        '倫理',
        '政治経済',
        '情報',
        '小論文',
        '面接',
    ];

    $selectedSubjects = old('exam_subjects', $student->exam_subjects ?? []);

    $desiredSchools = old('desired_schools', $student->desired_schools ?? ['']);
    $desiredSchools = array_values(array_filter(
        $desiredSchools,
        fn ($v) => !is_null($v)
    ));
    if (count($desiredSchools) === 0) {
        $desiredSchools = [''];
    }

    $teacherAssignments = old('teacher_assignments');

    if (is_null($teacherAssignments)) {
        $teacherAssignments = [];

        if (isset($student)) {
            foreach ($student->teachers as $teacher) {
                $assignedSubjects = $student->studentTeacherSubjects
                    ->where('teacher_id', $teacher->id)
                    ->pluck('subject')
                    ->values()
                    ->all();

                $teacherAssignments[] = [
                    'teacher_id' => $teacher->id,
                    'subjects' => $assignedSubjects,
                ];
            }
        }

        if (count($teacherAssignments) === 0) {
            $teacherAssignments[] = [
                'teacher_id' => '',
                'subjects' => [],
            ];
        }
    }
@endphp

<div class="form-grid">
    <div class="form-field">
        <label for="name" class="form-label">生徒氏名</label>
        <input
            type="text"
            name="name"
            id="name"
            class="form-input"
            value="{{ old('name', $student->name ?? '') }}"
            required
        >
    </div>

    <div class="form-field">
        <label for="name_kana" class="form-label">生徒氏名ふりがな</label>
        <input
            type="text"
            name="name_kana"
            id="name_kana"
            class="form-input"
            value="{{ old('name_kana', $student->name_kana ?? '') }}"
        >
    </div>

    <div class="form-field">
        <label for="school_name" class="form-label">学校名</label>
        <input
            type="text"
            name="school_name"
            id="school_name"
            class="form-input"
            value="{{ old('school_name', $student->school_name ?? '') }}"
        >
    </div>

    <div class="form-field">
        <label for="grade" class="form-label">学年</label>
        <input
            type="text"
            name="grade"
            id="grade"
            class="form-input"
            value="{{ old('grade', $student->grade ?? '') }}"
        >
    </div>

    <div class="form-field">
        <label for="status" class="form-label">ステータス</label>
        <select name="status" id="status" class="form-input" required>
            <option value="active" @selected(old('status', $student->status ?? 'active') === 'active')>在籍中</option>
            <option value="leave" @selected(old('status', $student->status ?? '') === 'leave')>休会</option>
            <option value="graduated" @selected(old('status', $student->status ?? '') === 'graduated')>卒業</option>
            <option value="withdrawn" @selected(old('status', $student->status ?? '') === 'withdrawn')>退塾</option>
        </select>
    </div>

    <div class="form-field">
        <label for="course_type" class="form-label">文系理系</label>
        <select name="course_type" id="course_type" class="form-input">
            <option value="">選択してください</option>
            <option value="liberal_arts" @selected(old('course_type', $student->course_type ?? '') === 'liberal_arts')>文系</option>
            <option value="science" @selected(old('course_type', $student->course_type ?? '') === 'science')>理系</option>
            <option value="undecided" @selected(old('course_type', $student->course_type ?? '') === 'undecided')>未定</option>
        </select>
    </div>

    <div class="form-field form-field--full">
        <label class="form-label">受験科目</label>
        <div class="subject-checkbox-grid">
            @foreach ($subjectOptions as $subject)
                <label class="checkbox-label">
                    <input
                        type="checkbox"
                        name="exam_subjects[]"
                        value="{{ $subject }}"
                        @checked(in_array($subject, $selectedSubjects, true))
                    >
                    {{ $subject }}
                </label>
            @endforeach
        </div>
    </div>

    <div class="form-field form-field--full">
        <label class="form-label">志望校（複数登録可）</label>

        <div id="desired-schools-list" class="desired-school-list">
            @foreach ($desiredSchools as $index => $school)
                <div class="desired-school-row">
                    <input
                        type="text"
                        name="desired_schools[]"
                        class="form-input"
                        value="{{ $school }}"
                        placeholder="志望校{{ $index + 1 }}"
                    >
                    <button type="button" class="remove-school-button">削除</button>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-school-button" class="button button--secondary">
            志望校を追加
        </button>
    </div>

    <div class="form-field form-field--full">
        <label class="form-label">担当講師・担当科目</label>

        <div id="teacher-assignment-list" class="teacher-assignment-list">
            @foreach ($teacherAssignments as $index => $assignment)
                <div class="teacher-assignment-card">
                    <div class="form-field">
                        <label class="form-label">講師</label>
                        <select name="teacher_assignments[{{ $index }}][teacher_id]" class="form-input">
                            <option value="">選択してください</option>
                            @foreach ($teachers as $teacher)
                                <option
                                    value="{{ $teacher->id }}"
                                    @selected((string)($assignment['teacher_id'] ?? '') === (string)$teacher->id)
                                >
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-field">
                        <label class="form-label">担当科目</label>
                        <div class="subject-checkbox-grid">
                            @foreach ($subjectOptions as $subject)
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="teacher_assignments[{{ $index }}][subjects][]"
                                        value="{{ $subject }}"
                                        @checked(in_array($subject, $assignment['subjects'] ?? [], true))
                                    >
                                    {{ $subject }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="button" class="remove-assignment-button button button--secondary">
                        この担当を削除
                    </button>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-teacher-assignment-button" class="button">
            担当講師を追加
        </button>
    </div>

    <div class="form-field">
        <label for="consultant_user_id" class="form-label">コンサル担当</label>
        <select name="consultant_user_id" id="consultant_user_id" class="form-input">
            <option value="">選択してください</option>
            @foreach ($consultants as $consultant)
                <option
                    value="{{ $consultant->id }}"
                    @selected((string) old('consultant_user_id', $student->consultant_user_id ?? auth()->id()) === (string) $consultant->id)
                >
                    {{ $consultant->name }}（{{ $consultant->role }}）
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-field form-field--full">
        <label for="note" class="form-label">備考</label>
        <textarea
            name="note"
            id="note"
            rows="4"
            class="form-input"
        >{{ old('note', $student->note ?? '') }}</textarea>
    </div>
</div>

<script type="application/json" id="teacher-options-data">
[
@foreach ($teachers as $teacher)
    {"id": {{ $teacher->id }}, "name": @json($teacher->name)}@if (! $loop->last),@endif
@endforeach
]
</script>

<script type="application/json" id="subject-options-data">
@json($subjectOptions)
</script>