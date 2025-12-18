<?php

require_once __DIR__ . '/../../vendor/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

function generarPDF($html, $filename = "documento.pdf", $download = false)
{
    // 🔥 LIMPIAR CUALQUIER SALIDA PREVIA
    if (ob_get_length()) {
        ob_end_clean();
    }

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // 🔥 ENVIAR EL PDF
    $dompdf->stream($filename, [
        "Attachment" => $download ? 1 : 0
    ]);

    // 🔥 CORTAR EJECUCIÓN PARA NO CORROMPER EL PDF
    exit;
}
