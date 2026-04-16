<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuidanceRecord\StoreGuidanceRecordRequest;
use App\Http\Requests\GuidanceRecord\UpdateGuidanceRecordRequest;
use App\Models\GuidanceRecord;
use App\Models\Student;
use Illuminate\Http\Request;

class GuidanceRecordController extends Controller
{
    public function create(Request $request)
    {
        $this->authorize('create', GuidanceRecord::class);

        $studentId = $request->input('student_id');

        if (! $studentId) {
            abort(403, '生徒が指定されていません。');
        }

        $student = Student::findOrFail($studentId);

        return view('guidance-records.create', compact('student'));
    }

    public function store(StoreGuidanceRecordRequest $request)
    {
        $this->authorize('create', GuidanceRecord::class);

        $student = Student::findOrFail($request->input('student_id'));

        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        GuidanceRecord::create($validated);

        return redirect()->route('students.show', $student)
            ->with('success', '学習記録を登録しました。');
    }

    public function edit(GuidanceRecord $guidanceRecord)
    {
        $this->authorize('update', $guidanceRecord);

        $student = $guidanceRecord->student;

        return view('guidance-records.edit', [
            'record' => $guidanceRecord,
            'student' => $student,
        ]);
    }

    public function update(UpdateGuidanceRecordRequest $request, GuidanceRecord $guidanceRecord)
    {
        $this->authorize('update', $guidanceRecord);

        $student = $guidanceRecord->student;

        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        $guidanceRecord->update($validated);

        return redirect()->route('students.show', $student)
            ->with('success', '学習記録を更新しました。');
    }
}