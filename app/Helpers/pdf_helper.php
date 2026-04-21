<?php

use Dompdf\Dompdf;
use Dompdf\Options;

if (!function_exists('generatePDF')) {
    /**
     * Generate PDF dari HTML
     * 
     * @param string $html Konten HTML
     * @param string $filename Nama file output
     * @param string $orientation 'portrait' atau 'landscape'
     */
    function generatePDF($html, $filename = 'document.pdf', $orientation = 'portrait')
    {
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        
        $dompdf->loadHtml($html, 'UTF-8');
        
        $dompdf->setPaper('A4', $orientation);
        
        $dompdf->render();
        
        $dompdf->stream($filename, ['Attachment' => true]);
        exit;
    }
}

if (!function_exists('savePDF')) {
   
    function savePDF($html, $filepath, $orientation = 'portrait')
    {
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', $orientation);
        $dompdf->render();
        
        file_put_contents($filepath, $dompdf->output());
        return $filepath;
    }
}