<?php
require_once BASE_PATH . '/app/helpers/pdf_helper.php';
require_once BASE_PATH . '/app/controllers/consultorioController.php';
require_once BASE_PATH . '/app/controllers/especialistaController.php';
require_once BASE_PATH . '/app/controllers/usuarioController.php';
require_once BASE_PATH . '/app/controllers/administradorConsultorioController.php';

// ESTA FUNCIÓN SE ENCARGA DE VALIDAR EL TIPO DE REPORTE Y EJECUTAR LA FUNCIÓN CORRESPONDIENTE
function reportesPdfController()
{
    // CAPTURAMOS EL TIPO EDE REPORTE ENVIADO DESDE LA VISTA
    $tipo = $_GET['tipo'];

    // SEGÚN EL TIPO DE REPORTE EJECUTAMOS X FUNCIÓN
    switch ($tipo) {
        case 'consultorios':
            reporteConsultoriosPDF();
            break;
        case 'especialistas':
            reporteEspecialistasPDF();
            break;
        case 'usuarios':
            reporteUsuariosPDF();
            break;
        case 'admnistradores':
            reporteAdministradoresPDF();
            break;

        default:
            exit();
            break;
    }
}

function reporteConsultoriosPDF()
{
    // CARGAR LA VISTA Y OBTENERLA COMO HTML
    ob_start();
    // ASIGNAMOS LOS DATOS DE LA FUNCIÓN EN EL CONTROLADOR ENLAZADO A UNA VARIABLE QUE PODAMOS MANIPULAR EN LA VISTA DEL PDF
    $consultorios = mostrarConsultorios();

    // ARCHIVO QUE TIENE LA INTERFAZ DISEÑADA EN HTML
    require BASE_PATH . '/app/views/pdf/consultorios_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_consultorios.pdf', false);
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

function reporteUsuariosPDF()
{
    // CARGAR LA VISTA Y OBTENERLA COMO HTML
    ob_start();

    // ASIGNAMOS LOS DATOS DE LA FUNCIÓN EN EL CONTROLADOR ENLAZADO A UNA VARIABLE QUE PODAMOS MANIPULAR EN LA VISTA DEL PDF
    $usuario = mostrarUsuario();

    // ARCHIVO QUE TIENE LA INTERFAZ DISEÑADA EN HTML
    require BASE_PATH . '/app/views/pdf/usuarios_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_usuarios.pdf', false);
}

function reporteAdministradoresPDF() {
    // CARGAR LA VISTA Y OBTENERLA COMO HTML
    ob_start();

    // ASIGNAMOS LOS DATOS DE LA FUNCIÓN EN EL CONTROLADOR ENLAZADO A UNA VARIABLE QUE PODAMOS MANIPULAR EN LA VISTA DEL PDF
    $administradores = mostrarAdministradoresConsultorios();

    // ARCHIVO QUE TIENE LA INTERFAZ DISEÑADA EN HTML
    require BASE_PATH . '/app/views/pdf/administradores_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_administradores.pdf', false);
}
