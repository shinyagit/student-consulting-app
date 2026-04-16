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
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new Mpdf([
            'fontDir' => array_merge($fontDirs, [
                resource_path('fonts'),
            ]),
            'fontdata' => $fontData + [
                'mplus1' => [
                    'R' => 'MPLUS1p-Regular.ttf',
                    'B' => 'MPLUS1p-Bold.ttf',
                ],
            ],
            'default_font' => 'mplus1',
        ]);

        $html = view('guidance-records.pdf', [
            'record' => $guidanceRecord,
        ])->render();

        $mpdf->WriteHTML($html);

        return response(
            $mpdf->Output('', 'S'),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="guidance-record.pdf"',
            ]
        );
    }
}