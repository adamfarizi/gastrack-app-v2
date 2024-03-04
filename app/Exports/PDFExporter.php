<?php

namespace App\Exports;

use Mpdf\Mpdf;

class PDFExporter
{
    public static function exportPDF($html, $fileName = 'output.pdf')
    {
        // Create mPDF object
        $mpdf = new Mpdf();

        // Write HTML content
        $mpdf->WriteHTML($html);

        // Output PDF
        $mpdf->Output($fileName, 'D');
    }
}
