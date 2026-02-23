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


require_once BASE_PATH . '/app/helpers/pdf_helper.php';
require_once BASE_PATH . '/app/controllers/especialistaController.php';
require_once BASE_PATH . '/app/controllers/asistenteController.php';



// ESTA FUNCIÓN SE ENCARGA DE VALIDAR EL TIPO DE REPORTE Y EJECUTAR LA FUNCIÓN CORRESPONDIENTE
function reportesPdfController()
{
    // VALIDACIÓN DE CONTEXTO:
    // Este controlador puede ser incluido desde otras vistas del sistema,
    // por lo tanto NO siempre existirá el parámetro 'tipo' en la URL.
    // 
    // Si no se valida, PHP lanzará un warning (Undefined array key)
    // que puede romper el renderizado de vistas normales.
    //
    // Con esta validación garantizamos que el controlador
    // SOLO ejecute lógica cuando realmente se está solicitando
    // la generación de un reporte PDF.
    if (!isset($_GET['tipo'])) {
        return; // No hay solicitud de reporte, se sale del controlador
    }

    // Se obtiene el tipo de reporte solicitado desde la URL
    $tipo = $_GET['tipo'];

    // Según el tipo de reporte recibido, se ejecuta
    // la función correspondiente para generar el PDF
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
    // CONTROL DE BUFFER DE SALIDA:
    // Si existe contenido previo en el buffer (HTML, espacios, warnings),
    // se limpia para evitar que dicho contenido interfiera
    // con la generación del PDF (headers, formato, errores).
    //
    // IMPORTANTE:
    // Esta limpieza SOLO debe hacerse aquí,
    // ya que esta función sí genera una salida especial (PDF).
    if (ob_get_length()) {
        ob_clean();
    }


    // Se inicia un nuevo buffer para capturar exclusivamente
    // el HTML que será convertido a PDF
    ob_start();

    // Se obtienen los datos necesarios desde el controlador
    $especialistas = mostrarEspecialistas();

    // Se carga la vista del PDF, cuyo contenido HTML
    // quedará almacenado en el buffer
    require BASE_PATH . '/app/views/pdf/especialistas_pdf.php';

    // Se obtiene el HTML generado y se limpia el buffer
    $html = ob_get_clean();

    // Se genera el PDF a partir del HTML capturado
    generarPDF($html, 'reporte_especialistas.pdf', false);
}

function reporteAsistentesPDF()
{
    // Se verifica si existe contenido previo en el buffer
    // para evitar conflictos al generar el PDF
    if (ob_get_length()) {
        ob_clean();
    }

    // Se inicia el buffer de salida para capturar el HTML del PDF
    ob_start();

    // Se obtienen los datos necesarios para el reporte
    $asistentes = mostrarAsistentes();

    // Se carga la vista HTML del PDF
    require BASE_PATH . '/app/views/pdf/asistentes_pdf.php';

    // Se captura el HTML generado y se cierra el buffer
    $html = ob_get_clean();

    // Se genera el archivo PDF
    generarPDF($html, 'reporte_asistentes.pdf', false);
}
