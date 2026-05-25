<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StudentFileController extends Controller
{
    public function store(Request $request, Student $student): RedirectResponse
    {
        $this->authorize('view', $student);

        $validated = $request->validate([
            'pdf_file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $file = $validated['pdf_file'];

        $path = $file->store("student-files/{$student->id}", 'public');

        StudentFile::create([
            'student_id' => $student->id,
            'uploaded_by' => auth()->id(),
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
        ]);

        return redirect()
            ->route('students.show', $student)
            ->with('success', 'PDFファイルをアップロードしました。');
    }

    public function show(Student $student, StudentFile $studentFile): StreamedResponse
    {
        $this->authorize('view', $student);

        abort_unless($studentFile->student_id === $student->id, 404);

        return Storage::disk('public')->response(
            $studentFile->file_path,
            $studentFile->original_name,
            ['Content-Type' => $studentFile->mime_type ?: 'application/pdf']
        );
    }

    public function destroy(Student $student, StudentFile $studentFile): RedirectResponse
    {
        $this->authorize('update', $student);

        abort_unless($studentFile->student_id === $student->id, 404);

        Storage::disk('public')->delete($studentFile->file_path);
        $studentFile->delete();

        return redirect()
            ->route('students.show', $student)
            ->with('success', 'PDFファイルを削除しました。');
    }
}