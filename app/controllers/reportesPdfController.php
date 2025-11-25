<?php
    require_once BASE_PATH . '/app/helpers/pdf_helper.php';
    require_once BASE_PATH . '/app/controllers/consultorioController.php';

    function reporteConsultoriosPDF() {
        // CARGAR LA VISTA Y OBTENERLA COMO HTML
        ob_start();
        // ASIGNAMOS LOS DATOS DE LA FUNCIÓN EN EL CONTROLADOR ENLAZADO A UNA VARIABLE QUE PODAMOS MANIPULAR EN LA VISTA DEL PDF
        $consultorios = mostrarConsultorios();

        // ARCHIVO QUE TIENE LA INTERFAZ DISEÑADA EN HTML
        require BASE_PATH . '/app/views/pdf/consultorios_pdf.php';
        $html = ob_get_clean();

        generarPDF($html, 'reporte_consultorios.pdf', false);
    }

    reporteConsultoriosPDF();
?>