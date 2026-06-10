<?php
// Iniciar sesión primero

use FontLib\Table\Type\head;

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
require_once BASE_PATH . '/app/controllers/historialesController.php';



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
        case 'historial_clinico':
            reporteHistorialClinicoPDF();
            break;

        case 'consulta_medica':
            reporteConsultaMedicaPDF();
            break;

        default:
            exit();
            break;
    }
}

function reporteHistorialClinicoPDF()
{
    // CARGAR LA VISTA Y OBTENERLA COMO HTML
    ob_start();

    // ASIGNAMOS LOS DATOS DE LA FUNCIÓN EN EL CONTROLADOR ENLAZADO A UNA VARIABLE QUE PODAMOS MANIPULAR EN LA VISTA DEL PDF
    $id_paciente = $_SESSION['user']['id_paciente'] ?? null;
    $datos = consultarHistorialClinicoPaciente($id_paciente);

    $paciente = $datos['paciente'];
    $historiales = $datos['historial'];

    // ARCHIVO QUE TIENE LA INTERFAZ DISEÑADA EN HTML
    require BASE_PATH . '/app/views/pdf/historial_clinico_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_historial_clinico.pdf', false);
}

function reporteConsultaMedicaPDF()
{
    // CARGAR LA VISTA Y OBTENERLA COMO HTML
    ob_start();

    // ASIGNAMOS LOS DATOS DE LA FUNCIÓN EN EL CONTROLADOR ENLAZADO A UNA VARIABLE QUE PODAMOS MANIPULAR EN LA VISTA DEL PDF
    $id_consulta = $_GET['id_consulta'] ?? null;
    $id_paciente = $_SESSION['user']['id_paciente'] ?? null;

    $consulta = consultarConsultaMedica($id_consulta);

    // 3. 🛡️ EL CANDADO DE SEGURIDAD (La validación vital)
    // Verificamos si la consulta existe y, lo más importante, 
    // si el id_paciente DENTRO de esa consulta es igual al paciente logueado.
    if (!$consulta || $consulta['id_paciente'] != $id_paciente) {
        // Si entra aquí, es porque alguien alteró la URL o la consulta no existe.
        // Lo sacamos del sistema inmediatamente.
        header('Location: ' . BASE_URL . '/paciente/lista-de-citas?error=acceso_denegado');
        exit();
    }

    // SI PASÓ EL CANDADO ES SEGURO CONTINUAR CON LA GENERACIÓN DEL PDF

    $datos = consultarHistorialClinicoPaciente($id_paciente);

    $paciente = $datos['paciente'];

    // ARCHIVO QUE TIENE LA INTERFAZ DISEÑADA EN HTML
    require BASE_PATH . '/app/views/pdf/consulta_medica_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_consulta_medica.pdf', false);
}
