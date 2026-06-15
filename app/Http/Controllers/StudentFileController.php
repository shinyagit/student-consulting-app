<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StudentFileController extends Controller
{
    public function store(Request $request, Student $student): RedirectResponse
    {
        $this->authorize('view', $student);

        $validated = $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:pdf,png,jpg,jpeg',
                'max:10240',
            ],
        ]);

        $file = $validated['file'];
        $mimeType = $file->getClientMimeType();
        $originalName = $file->getClientOriginalName();

        if (str_starts_with($mimeType, 'image/')) {
            $stored = $this->storeOptimizedImage($file, $student);
        } else {
            $path = $file->store("student-files/{$student->id}", 'public');

            $stored = [
                'path' => $path,
                'mime_type' => $mimeType,
                'size' => $file->getSize(),
            ];
        }

        StudentFile::create([
            'student_id' => $student->id,
            'uploaded_by' => auth()->id(),
            'original_name' => $originalName,
            'file_path' => $stored['path'],
            'mime_type' => $stored['mime_type'],
            'file_size' => $stored['size'],
        ]);

        return redirect()
            ->route('students.show', $student)
            ->with('success', 'ファイルをアップロードしました。');
    }

    private function storeOptimizedImage($file, Student $student): array
    {
        $manager = ImageManager::usingDriver(Driver::class);

        $image = $manager->decodePath($file->getPathname());

        $image->scaleDown(width: 1600, height: 1600);

        $encoded = $image->encodeUsingFormat(
            Format::JPEG,
            quality: 82,
            progressive: true
        );

        $fileName = uniqid('image_', true) . '.jpg';
        $path = "student-files/{$student->id}/{$fileName}";

        Storage::disk('public')->put($path, (string) $encoded);

        return [
            'path' => $path,
            'mime_type' => 'image/jpeg',
            'size' => Storage::disk('public')->size($path),
        ];
    }

    public function show(Student $student, StudentFile $studentFile): StreamedResponse
    {
        $this->authorize('view', $student);

        abort_unless($studentFile->student_id === $student->id, 404);

        return Storage::disk('public')->response(
            $studentFile->file_path,
            $studentFile->original_name,
            ['Content-Type' => $studentFile->mime_type ?: 'application/octet-stream']
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
            ->with('success', 'ファイルを削除しました。');
    }
}