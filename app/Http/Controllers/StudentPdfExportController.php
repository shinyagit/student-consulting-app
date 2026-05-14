<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class StudentPdfExportController extends Controller
{
    public function exportAll(): BinaryFileResponse
    {
        if (! class_exists(\ZipArchive::class)) {
            abort(500, 'ZIP拡張が有効ではありません。PHPのzip拡張をインストールしてください。');
        }

        $this->authorize('viewAny', Student::class);

        $students = Student::query()
            ->with([
                'consultant',
                'teachers',
                'studentTeacherSubjects',
                'guidanceRecords' => function ($query) {
                    $query->with('user')->latest('consulted_at');
                },
            ])
            ->orderByRaw("
                CASE status
                    WHEN 'active' THEN 0
                    WHEN 'leave' THEN 1
                    WHEN 'withdrawn' THEN 2
                    WHEN 'graduated' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('id')
            ->get();

        if ($students->isEmpty()) {
            abort(404, '出力対象の生徒がいません。');
        }

        $workDir = storage_path('app/tmp/student-pdf-export-' . Str::uuid());
        $pdfDir = $workDir . '/pdfs';
        $mpdfTempDir = storage_path('app/mpdf-temp');

        File::ensureDirectoryExists($workDir);
        File::ensureDirectoryExists($pdfDir);
        File::ensureDirectoryExists($mpdfTempDir);

        foreach ($students as $student) {
            $html = view('students.pdf.bulk', [
                'student' => $student,
                'records' => $student->guidanceRecords,
            ])->render();

            $tempDir = storage_path('app/mpdf-temp');
            if (! is_dir($tempDir)) {
                mkdir($tempDir, 0775, true);
            }

            $defaultConfig = (new ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'tempDir' => $tempDir,
                'fontDir' => array_merge($fontDirs, [
                    resource_path('fonts'),
                ]),
                'fontdata' => $fontData + [
                    'notosansjp' => [
                        'R' => 'NotoSansJP-VariableFont_wght.ttf',
                        'B' => 'NotoSansJP-VariableFont_wght.ttf',
                    ],
                    'mplus1' => [
                        'R' => 'MPLUS1p-Regular.ttf',
                        'B' => 'MPLUS1p-Bold.ttf',
                    ],
                ],
                'default_font' => 'mplus1',
            ]);

            $mpdf->WriteHTML($html);

            $safeName = $this->makeSafeFilename(
                $student->id . '-' . ($student->name ?: 'student') . '-' . ($student->grade ?: 'grade-unknown')
            );

            $pdfPath = $pdfDir . '/' . $safeName . '.pdf';
            $mpdf->Output($pdfPath, \Mpdf\Output\Destination::FILE);
        }

        $zipPath = $workDir . '/students-pdfs.zip';

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            File::deleteDirectory($workDir);
            abort(500, 'ZIPファイルの作成に失敗しました。');
        }

        foreach (File::files($pdfDir) as $file) {
            $zip->addFile($file->getPathname(), $file->getFilename());
        }

        $zip->close();

        return response()->download($zipPath, 'students-pdfs.zip')->deleteFileAfterSend(true);
    }

    private function makeSafeFilename(string $name): string
    {
        $name = preg_replace('/[\\\\\\/\\:\\*\\?\\\"\\<\\>\\|]/u', '-', $name);
        $name = preg_replace('/\\s+/u', '_', $name);
        $name = trim($name, '-_');

        return $name !== '' ? $name : 'student';
    }
}