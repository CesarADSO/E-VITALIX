<?php
// Iniciar sesión primero
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar autenticación básica (sin validación de rol específico)
if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo "Acceso no autorizado";
    exit();
}

// Limpiar buffer actual si existe
if (ob_get_length()) {
    ob_clean();
}


ob_start();

require_once BASE_PATH . '/app/helpers/pdf_helper.php';
require_once BASE_PATH . '/app/controllers/especialistaController.php';
require_once BASE_PATH . '/app/controllers/asistenteController.php';



// ESTA FUNCIÓN SE ENCARGA DE VALIDAR EL TIPO DE REPORTE Y EJECUTAR LA FUNCIÓN CORRESPONDIENTE
function reportesPdfController()
{
    // CAPTURAMOS EL TIPO EDE REPORTE ENVIADO DESDE LA VISTA
    $tipo = $_GET['tipo'];

    // SEGÚN EL TIPO DE REPORTE EJECUTAMOS X FUNCIÓN
    switch ($tipo) {
        case 'especialistas':
            reporteEspecialistasPDF();
            break;

        case 'asistentes':
            reporteAsistentesPDF();
            break;

        default:
            exit();
            break;
    }
}


function reporteEspecialistasPDF()
{
    // CARGAR LA VISTA Y OBTENERLA COMO HTML
    ob_start();
    // ASIGNAMOS LOS DATOS DE LA FUNCIÓN EN EL CONTROLADOR ENLAZADO A UNA VARIABLE QUE PODAMOS MANIPULAR EN LA VISTA DEL PDF
    $especialistas = mostrarEspecialistas();

    // ARCHIVO QUE TIENE LA INTERFAZ DISEÑADA EN HTML
    require BASE_PATH . '/app/views/pdf/especialistas_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_especialistas.pdf', false);
}

function reporteAsistentesPDF() {
    // CARGAR LA VISTA Y OBTENERLA COMO HTML
    ob_start();
    // ASIGNAMOS LOS DATOS DE LA FUNCIÓN EN EL CONTROLADOR ENLAZADO A UNA VARIABLE QUE PODAMOS MANIPULAR EN LA VISTA DEL PDF
    $asistentes = mostrarAsistentes();

    // ARCHIVO QUE TIENE LA INTERFAZ DISEÑADA EN HTML
    require BASE_PATH . '/app/views/pdf/asistentes_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_asistentes.pdf', false);
}