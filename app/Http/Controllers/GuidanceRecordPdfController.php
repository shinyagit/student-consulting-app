<?php

namespace App\Http\Controllers;

use App\Models\GuidanceRecord;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;

class GuidanceRecordPdfController extends Controller
{
    public function show(GuidanceRecord $guidanceRecord)
    {
        $guidanceRecord->load(['student', 'user']);

        $this->authorize('view', $guidanceRecord->student);

        $html = view('pdf.guidance-record', [
            'record' => $guidanceRecord,
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
                storage_path('fonts'),
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

        return response($mpdf->Output('', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="guidance-record-' . $guidanceRecord->id . '.pdf"',
        ]);
    }
}