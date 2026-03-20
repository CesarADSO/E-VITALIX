<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/planesModel.php';
// IMPORTAMOS EL AUTOLOAD DE MERCADO PAGO
require_once __DIR__ . '/../../vendor/autoload.php';

// IMPORTAMOS LAS DEPENDENCIAS DE MERCADOPAGO
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;



$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // CASO A: El usuario entra a revisar el plan antes de pagar
        if (isset($_GET['id_plan'])) {
            prepararResumenPago($_GET['id_plan']);
        }

        if (isset($_GET['status']) && $_GET['status'] === 'approved') {
            finalizarPagoExitoso();
        }

        traerId();
        break;

    default:
        # code...
        break;
}

function traerId()
{
    // INSTANCIAMOS LA CLASE DEL MODELO
    $objPlan = new Plan();

    // ACCEDEMOS AL MÉTODO DE LA CLASE PLAN
    $resultado = $objPlan->traerId();

    // RETORNAMOS RESULTADO
    return $resultado;
}

function PrepararResumenPago($id_plan)
{
    // INSTANCIAMOS LA CLASE DEL MODELO
    $objPlan = new Plan();

    // ACCEDEMOS AL MÉTODO DE LA CLASE PLAN
    $resultado = $objPlan->consultarPlanPorId($id_plan);

    // REANUDAMOS SESIÓN: Aquí es donde creamos la "nota" de qué plan se eligió
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // CREACIÓN DE LA SESIÓN: Guardamos el ID del plan que el usuario quiere comprar
    $_SESSION['plan_seleccionado_id'] = $id_plan;

    // CONFIGURACIÓN DE MERCADO PAGO
    MercadoPagoConfig::setAccessToken('APP_USR-3664831415325463-031718-62ff1d0ac2d63b96a7029f6058001f74-3273776043');


    // CREAMOS UNA VARIABLE $client E INSTANCIAMOS LA CLASE PreferenceClient
    $client = new PreferenceClient();

    // CREACIÓN DE LA PREFERENCIA (La "factura" digital)
    try {
        $preference = $client->create([
            "items" => [[
                "id" => $resultado['id'],
                "title" => "Suscripción: " . $resultado['nombre'],
                "quantity" => 1,
                "unit_price" => (float)$resultado['precio'],
                "currency_id" => "COP"
            ]],
            // Enviamos el ID del consultorio que ya tienes en la sesión del LOGIN
            "external_reference" => $_SESSION['user']['id_consultorio'],
            "back_urls" => [
                "success" => BASE_URL . '/admin/pago-exitoso',
                "failure" => BASE_URL . '/admin/pago-fallido'
            ],
            // "auto_return" => "approved",
        ]);
        $preferenceId = $preference->id;
    } catch (MercadoPago\Exceptions\MPApiException $e) {
        // ESTO TE DIRÁ EL ERROR REAL
        echo "Hubo un error en la API: <br>";
        print_r($e->getApiResponse()->getContent());
        exit;
    } catch (Exception $e) {
        echo "Error general: " . $e->getMessage();
        exit;
    }

    // CARGAMOS LA VISTA: Le pasamos los datos del plan y el ID de Mercado Pago
    require_once BASE_PATH . '/app/views/dashboard/administrador/confirmar-compra.php';
}

function finalizarPagoExitoso() {
    // PRIMERO REANUDAMOS LA SESSIÓN DE FORMA SEGURA
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // OBTENEMOS EL ID DEL CONSULTORIO DE LA EXTERNAL_REFERENCE DE MERCADO PAGO
    // Y EL ID DEL PLAN DE LA SESSIÓN QUE CREAMOS EN LA FUNCIÓN ANTERIOR COMO ES UNA VARIABLE SESSION ENTONCES ESTÁ ESTÁ DENTRO DEL SCOPE DE ESTA FUNCIÓN Y NO MUERE CUANDO TERMINA LA FUNCIÓN PrepararResumenPago
    $id_consultorio = $_GET['external_reference'];
    $id_plan = $_SESSION['plan_seleccionado_id'];

    // VALIDAMOS SI EXISTEN LOS DOS IDS EMPEZAMOS A HACER LA LÓGICA
    if ($id_consultorio && $id_plan) {
        // INSTANCIAMOS LA CLASE DEL MODELO
        $objPlan = new Plan();

        // ACCEDEMOS AL MÉTODO DE LA CLASE
        $resultado = $objPlan->actualizarPlanConsultorio($id_consultorio, $id_plan);

        // ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO
        if ($resultado === true) {
            // Limpiamos la sesión
            unset($_SESSION['plan_seleccionado_id']);

            // MOSTRAMOS EL MENSAJE DE CONFIRMACIÓN
            mostrarSweetAlert('success', '¡Suscripción exitosa!', 'Tu plan ya ha sido actualizado ya puedes disfrutar de los nuevos beneficios', '/E-VITALIX/admin/dashboard');
        }
        else {
            mostrarSweetAlert('error', 'Error al actualizar tu plan', 'La compra fue aprobada pero no pudimos actualizar tu plan contacta a soporte', '/E-VITALIX/admin/precios');
        }
    }
}
