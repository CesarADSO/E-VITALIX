<?php
// 1. PRIMERO SIEMPRE LOS 'USE' (Regla estricta de PHP)
// IMPORTAMOS LAS DEPENDENCIAS DE MERCADOPAGO
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Payment\PaymentClient; // <-- AGREGA ESTA LÍNEA

// 2. DESPUÉS LAS DEPENDENCIAS Y AUTOLOADS
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/planesModel.php';
// IMPORTAMOS EL AUTOLOAD DE MERCADO PAGO
require_once __DIR__ . '/../../vendor/autoload.php';


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // 1. CAPTURAMOS LO QUE VENGA EN LA URL
        $payment_id = $_GET['payment_id'] ?? $_GET['collection_id'] ?? null;
        $status = $_GET['status'] ?? $_GET['collection_status'] ?? null;

        // 2. PRIORIDAD 1: Si viene un ID de pago o un Status, procesamos el retorno
        if ($payment_id || $status) {
            // Esta función ahora será la encargada de validar todo
            procesarRetornoPago();
            exit; 
        }

        // PRIORIDAD 2: ¿El usuario apenas va a revisar el plan?
        if (isset($_GET['id_plan'])) {
            prepararResumenPago($_GET['id_plan']);
            mostrarInfoPlanContratado($_GET['id_plan']);
            exit;
        }


        traerId();
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
    MercadoPagoConfig::setAccessToken('APP_USR-2681349028882389-022514-f4ddad9c4de0474a5a616ceb2b27f6a2-2131980827');


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
                "failure" => BASE_URL . '/admin/pago-fallido',
            ],
            "auto_return" => "approved",
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




function procesarRetornoPago()
{
    // PRIMERO REANUDAMOS LA SESSIÓN DE FORMA SEGURA
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // 1. CAPTURAMOS LOS DATOS
    // Mercado pago puede mandar 'payment_id' o a veces 'collection_id' dependiendo del flujo, por eso validamos ambos
    $payment_id = $_GET['payment_id'] ?? $_GET['collection_id'] ?? null;
    $id_plan = $_SESSION['plan_seleccionado_id'] ?? null;
    
    // --- 🚨 INICIO DE PRUEBA DE DEBUGGING ---
    if (isset($_GET['debug'])) {
        echo "<h3>Reporte de Diagnóstico:</h3>";
        echo "Payment ID recibido: " . ($payment_id ? $payment_id : 'NULO') . "<br>";
        echo "ID del Plan en Sesión: " . ($id_plan ? $id_plan : 'NULO (Se perdió la sesión)') . "<br>";
        exit; // Detenemos todo para poder leer
    }

    // Si no hay ID de pago o no sabemos qué plan quería, lo mandamos a error
    if (!$payment_id || !$id_plan) {
        finalizarPagoFallido();
        return;
    }
    

    // 2. NOS CONECTAMOS A MERCADO PAGO PARA PREGUNTAR LA VERDAD
    MercadoPagoConfig::setAccessToken('APP_USR-2681349028882389-022514-f4ddad9c4de0474a5a616ceb2b27f6a2-2131980827');
    $client = new PaymentClient();
    
    try {
        // Buscamos el recibo real en los servidores de Mercado Pago
        $payment = $client->get($payment_id);

        // Extraemos los datos a prueba de hackers
        $estado_real = $payment->status; // 'approved', 'pending', 'rejected', etc.
        $id_consultorio = $payment->external_reference; // El ID del consultorio que mandamos originalmente

        // 3. LÓGICA DE DECISIÓN: Solo si el estado real es 'approved' y el ID del consultorio coincide, damos por bueno el pago
        if ($estado_real === 'approved' && $id_consultorio) {
            // INSTANCIAMOS LA CLASE DEL MODELO
            $objPlan = new Plan();

            $resultado = $objPlan->actualizarPlanConsultorio($id_consultorio, $id_plan);
            
            if ($resultado === true) {
                // Limpiamos la sesión
                unset($_SESSION['plan_seleccionado_id']);

                // MOSTRAMOS EL MENSAJE DE CONFIRMACIÓN Y REDIRECCIONAMOS
                mostrarSweetAlert('success', '¡Suscripción exitosa!', 'Tu plan ya ha sido actualizado. Gracias por tu compra.', BASE_URL . '/administrador/dashboard');
            }
            else {
                mostrarSweetAlert('error', 'Error al actualizar plan', 'Tu pago fue aprobado pero hubo un error al actualizar tu plan. Por favor contacta soporte.', BASE_URL . '/admin/precios');
            }
        }
        else {
            // si el estado del pago es rechazado, pendiente o cualquier otro, lo tratamos como un pago fallido
            finalizarPagoFallido();
        }

    } catch (Exception $e) {
        // Si el payment_id no es válido o hay un error de conexión, lo tratamos como un pago fallido
        finalizarPagoFallido();
    }
}

function finalizarPagoFallido()
{
    // REANUDAMOS LA SESIÓN
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // LIMPIAMOS EL ID DEL PLAN PARA EVITAR ERRORES SI REINTENTA
    if (isset($_SESSION['plan_seleccionado_id'])) {
        unset($_SESSION['plan_seleccionado_id']);
    }

    // MOSTRAR EL MENSAJE DE ERROR Y REDIRECCIONAR
    mostrarSweetAlert('error', 'Pago no completado', 'No pudimos procesar tu pago. Por favor, intenta de nuevo o usa otro método de pago', BASE_URL . '/admin/precios');
}

function mostrarInfoPlanContratado($id_plan) {
    // INTANCIAMOS LA CLASE DEL MODELO
    $objPlan = new Plan();

    // ACCEDEMOS AL MÉTODO DE LA CLASE
    $resultado = $objPlan->consultarPlanPorId($id_plan);

    // RETORNAMOS RESULTADO
    return $resultado;
}