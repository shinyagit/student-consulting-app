<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teacher\StoreTeacherRequest;
use App\Http\Requests\Teacher\UpdateTeacherRequest;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Teacher::class);

        $teachers = Teacher::query()
            ->withCount('students')
            ->orderBy('teacher_code')
            ->paginate(20);

        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        $this->authorize('create', Teacher::class);

        return view('teachers.create');
    }

    public function store(StoreTeacherRequest $request)
    {
        $this->authorize('create', Teacher::class);

        $validated = $request->validated();

        $teacher = Teacher::create([
            'teacher_code' => $validated['teacher_code'],
            'name' => $validated['name'],
            'department' => $validated['department'] ?? null,
            'school_year' => $validated['school_year'] ?? null,
            'age' => $validated['age'] ?? null,
            'status' => $validated['status'],
            'note' => $validated['note'] ?? null,
        ]);

        $subjects = $this->normalizeSubjects($validated['available_subjects'] ?? []);

        if (! empty($subjects)) {
            $teacher->teacherSubjects()->createMany(
                collect($subjects)
                    ->map(fn ($subject) => ['subject' => $subject])
                    ->all()
            );
        }

        return redirect()
            ->route('teachers.show', $teacher)
            ->with('success', '講師を登録しました。');
    }

    public function show(Teacher $teacher)
    {
        $this->authorize('view', $teacher);

        $teacher->load([
            'teacherSubjects',
            'students' => fn ($query) => $query->orderBy('name'),
        ]);

        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $this->authorize('update', $teacher);

        $teacher->load('teacherSubjects');

        return view('teachers.edit', compact('teacher'));
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $this->authorize('update', $teacher);

        $validated = $request->validated();

        $teacher->update([
            'teacher_code' => $validated['teacher_code'],
            'name' => $validated['name'],
            'department' => $validated['department'] ?? null,
            'school_year' => $validated['school_year'] ?? null,
            'age' => $validated['age'] ?? null,
            'status' => $validated['status'],
            'note' => $validated['note'] ?? null,
        ]);

        $subjects = $this->normalizeSubjects($validated['available_subjects'] ?? []);

        $teacher->teacherSubjects()->delete();

        if (! empty($subjects)) {
            $teacher->teacherSubjects()->createMany(
                collect($subjects)
                    ->map(fn ($subject) => ['subject' => $subject])
                    ->all()
            );
        }

        return redirect()
            ->route('teachers.show', $teacher)
            ->with('success', '講師情報を更新しました。');
    }

    private function normalizeSubjects(array $subjects): array
    {
        return collect($subjects)
            ->filter(fn ($value) => filled($value))
            ->map(fn ($value) => trim($value))
            ->filter(fn ($value) => $value !== '')
            ->unique()
            ->values()
            ->all();
    }
}