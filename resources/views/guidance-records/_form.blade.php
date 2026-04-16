<input type="hidden" name="student_id" value="{{ old('student_id', $student->id) }}">

<div class="guidance-form">
    <div class="form-field">
        <label for="consulted_at" class="form-label">実施日時</label>
        <input
            type="datetime-local"
            name="consulted_at"
            id="consulted_at"
            class="form-input"
            value="{{ old('consulted_at', isset($record) && $record->consulted_at ? $record->consulted_at->format('Y-m-d\TH:i') : '') }}"
            required
        >
    </div>

    <div class="form-field">
        <label for="growth_point" class="form-label">成長点</label>
        <textarea
            name="growth_point"
            id="growth_point"
            class="form-input"
            rows="4"
        >{{ old('growth_point', $record->growth_point ?? '') }}</textarea>
    </div>

    <div class="form-field">
        <label for="challenge_point" class="form-label">課題点</label>
        <textarea
            name="challenge_point"
            id="challenge_point"
            class="form-input"
            rows="4"
        >{{ old('challenge_point', $record->challenge_point ?? '') }}</textarea>
    </div>

    <div class="form-field">
        <label for="self_score" class="form-label">自己評価</label>
        <input
            type="number"
            name="self_score"
            id="self_score"
            class="form-input"
            min="0"
            max="100"
            value="{{ old('self_score', $record->self_score ?? '') }}"
        >
    </div>

    <div class="form-field">
        <label for="note" class="form-label">NOTE</label>
        <textarea
            name="note"
            id="note"
            class="form-input"
            rows="4"
        >{{ old('note', $record->note ?? '') }}</textarea>
    </div>

    <div class="form-field">
        <label for="next_plan_date" class="form-label">次回実施日</label>
        <input
            type="date"
            name="next_plan_date"
            id="next_plan_date"
            class="form-input"
            value="{{ old('next_plan_date', isset($record) && $record->next_plan_date ? $record->next_plan_date->format('Y-m-d') : '') }}"
        >
    </div>

    <div class="guidance-subject-grid">
        <div class="guidance-subject-card">
            <div class="form-field">
                <label for="subject1_name" class="form-label">科目①</label>
                <input
                    type="text"
                    name="subject1_name"
                    id="subject1_name"
                    class="form-input"
                    value="{{ old('subject1_name', $record->subject1_name ?? '') }}"
                >
            </div>

            <div class="form-field">
                <label for="subject1_detail" class="form-label">内容①</label>
                <textarea
                    name="subject1_detail"
                    id="subject1_detail"
                    class="form-input"
                    rows="4"
                >{{ old('subject1_detail', $record->subject1_detail ?? '') }}</textarea>
            </div>
        </div>

        <div class="guidance-subject-card">
            <div class="form-field">
                <label for="subject2_name" class="form-label">科目②</label>
                <input
                    type="text"
                    name="subject2_name"
                    id="subject2_name"
                    class="form-input"
                    value="{{ old('subject2_name', $record->subject2_name ?? '') }}"
                >
            </div>

            <div class="form-field">
                <label for="subject2_detail" class="form-label">内容②</label>
                <textarea
                    name="subject2_detail"
                    id="subject2_detail"
                    class="form-input"
                    rows="4"
                >{{ old('subject2_detail', $record->subject2_detail ?? '') }}</textarea>
            </div>
        </div>

        <div class="guidance-subject-card">
            <div class="form-field">
                <label for="subject3_name" class="form-label">科目③</label>
                <input
                    type="text"
                    name="subject3_name"
                    id="subject3_name"
                    class="form-input"
                    value="{{ old('subject3_name', $record->subject3_name ?? '') }}"
                >
            </div>

            <div class="form-field">
                <label for="subject3_detail" class="form-label">内容③</label>
                <textarea
                    name="subject3_detail"
                    id="subject3_detail"
                    class="form-input"
                    rows="4"
                >{{ old('subject3_detail', $record->subject3_detail ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <div class="form-field">
        <label for="other_plan" class="form-label">その他</label>
        <textarea
            name="other_plan"
            id="other_plan"
            class="form-input"
            rows="4"
        >{{ old('other_plan', $record->other_plan ?? '') }}</textarea>
    </div>
</div>