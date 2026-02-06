<?php
    require_once __DIR__ . '/../helpers/alert_helper.php';
    require_once __DIR__ . '/../models/historialesModel.php';

    $method = $_SERVER['REQUEST_METHOD'];
    switch ($method) {
        case 'GET':
            mostrarPacientesConConsulta();
            break;
        
        default:
            # code...
            break;
    }

    function mostrarPacientesConConsulta() {
        
        // INSTANCIAMOS LA CLASE 
        $historiales = new Historiales();

        // REANUDAMOS LA SESIÓN DE FORMA SEGURA
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // OBTENEMOS EL ID DEL ESPECIALISTA 
        $id_especialista = $_SESSION['user']['id_especialista'];


        // ACCEDEMOS AL MÉTODO DE LA CLASE HISTORIALES
        $resultado = $historiales->ConsultarPacienteConConsulta($id_especialista);

        return $resultado;
    }


?>