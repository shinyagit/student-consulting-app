<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Models\Student;
use App\Models\StudentTeacherSubject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Student::class);

        $query = Student::query()
            ->with(['consultant'])
            ->withCount('guidanceRecords')
            ->when(request('keyword'), function ($query, $keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when(request('grade'), function ($query, $grade) {
                $query->where('grade', $grade);
            })
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when(request('course_type'), function ($query, $courseType) {
                $query->where('course_type', $courseType);
            });

        if (auth()->user()->role === 'staff') {
            $query->where('consultant_user_id', auth()->id());
        }

        $students = $query
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('students.index', compact('students'));
    }

    public function create(): View
    {
        $this->authorize('create', Student::class);

        $teachers = Teacher::with('teacherSubjects')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $consultants = User::whereIn('role', ['admin', 'staff'])
            ->orderBy('name')
            ->get();

        return view('students.create', compact('teachers', 'consultants'));
    }

    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $this->authorize('create', Student::class);

        $validated = $this->normalizeStudentInput($request->validated());

        if (blank($validated['consultant_user_id'] ?? null)) {
            $validated['consultant_user_id'] = auth()->id();
        }

        $student = Student::create(
            collect($validated)->except('teacher_assignments')->all()
        );

        $this->syncTeacherAssignments($student, $validated['teacher_assignments'] ?? []);

        return redirect()
            ->route('students.show', $student)
            ->with('success', '生徒情報を登録しました。');
    }

    public function show(Student $student): View
    {
        $this->authorize('view', $student);

        $student->load([
            'consultant',
            'teachers.teacherSubjects',
            'studentTeacherSubjects',
        ]);

        $records = $student->guidanceRecords()
            ->with('user')
            ->latest('consulted_at')
            ->paginate(10);

        return view('students.show', compact('student', 'records'));
    }

    public function edit(Student $student): View
    {
        $this->authorize('update', $student);

        $teachers = Teacher::with('teacherSubjects')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $consultants = User::whereIn('role', ['admin', 'staff'])
            ->orderBy('name')
            ->get();

        $student->load([
            'consultant',
            'teachers.teacherSubjects',
            'studentTeacherSubjects',
        ]);

        return view('students.edit', compact('student', 'teachers', 'consultants'));
    }

    public function update(UpdateStudentRequest $request, Student $student): RedirectResponse
    {
        $this->authorize('update', $student);

        $validated = $this->normalizeStudentInput($request->validated());

        if (
            auth()->user()->role === 'staff' &&
            isset($validated['consultant_user_id']) &&
            (int) $validated['consultant_user_id'] !== (int) $student->consultant_user_id
        ) {
            unset($validated['consultant_user_id']);
        }

        $student->update(
            collect($validated)->except('teacher_assignments')->all()
        );

        $this->syncTeacherAssignments($student, $validated['teacher_assignments'] ?? []);

        return redirect()
            ->route('students.show', $student)
            ->with('success', '生徒情報を更新しました。');
    }

    private function normalizeStudentInput(array $validated): array
    {
        $validated['desired_schools'] = array_values(
            array_filter($validated['desired_schools'] ?? [], fn ($v) => filled($v))
        );

        $validated['exam_subjects'] = array_values(
            array_filter($validated['exam_subjects'] ?? [], fn ($v) => filled($v))
        );

        $validated['teacher_assignments'] = array_values(array_filter(
            $validated['teacher_assignments'] ?? [],
            fn ($assignment) => filled($assignment['teacher_id'] ?? null)
        ));

        $validated['teacher_assignments'] = array_map(function ($assignment) {
            $assignment['subjects'] = array_values(
                array_filter($assignment['subjects'] ?? [], fn ($v) => filled($v))
            );

            return $assignment;
        }, $validated['teacher_assignments']);

        return $validated;
    }

    private function syncTeacherAssignments(Student $student, array $teacherAssignments): void
    {
        $teacherIds = [];
        $subjectRows = [];

        foreach ($teacherAssignments as $assignment) {
            $teacherId = $assignment['teacher_id'] ?? null;

            if (! $teacherId) {
                continue;
            }

            $teacherIds[] = (int) $teacherId;

            foreach (($assignment['subjects'] ?? []) as $subject) {
                if (! filled($subject)) {
                    continue;
                }

                $subjectRows[] = [
                    'student_id' => $student->id,
                    'teacher_id' => (int) $teacherId,
                    'subject' => $subject,
                ];
            }
        }

        $student->teachers()->sync(array_values(array_unique($teacherIds)));

        StudentTeacherSubject::query()
            ->where('student_id', $student->id)
            ->delete();

        if (! empty($subjectRows)) {
            StudentTeacherSubject::insert($subjectRows);
        }
    }
}