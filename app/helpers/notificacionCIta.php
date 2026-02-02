<?php
require_once __DIR__ . '/mailer_helper.php';

/**
 * Enviar notificación por correo al especialista cuando se agenda una cita
 * 
 * @param string $emailEspecialista Email del especialista
 * @param string $nombreEspecialista Nombre completo del especialista
 * @param string $nombrePaciente Nombre completo del paciente
 * @param string $fecha Fecha de la cita (formato: Y-m-d)
 * @param string $horaInicio Hora de inicio (formato: H:i:s)
 * @param string $horaFin Hora de fin (formato: H:i:s)
 * @param string $servicio Nombre del servicio (opcional)
 * @param string $motivoConsulta Motivo de la consulta (opcional)
 * 
 * @return bool True si se envió exitosamente, False si hubo error
 */
function enviarNotificacionCitaEspecialista(
    $emailEspecialista,
    $nombreEspecialista,
    $nombrePaciente,
    $fecha,
    $horaInicio,
    $horaFin,
    $servicio = 'No especificado',
    $motivoConsulta = ''
) {
    try {
        // Inicializar PHPMailer
        $mail = mailer_init();

        // Configurar remitente
        $mail->setFrom('evitalix558@gmail.com', 'E-VITALIX - Sistema de Citas');

        // Configurar destinatario
        $mail->addAddress($emailEspecialista, $nombreEspecialista);

        // Asunto del correo
        $mail->Subject = "Nueva Cita Agendada - E-VITALIX";

        // Formatear fecha y hora para mostrar de manera legible
        $fechaFormateada = date('l, d \d\e F \d\e Y', strtotime($fecha));
        $fechaFormateada = ucfirst($fechaFormateada);
        $fechaFormateada = traducirFecha($fechaFormateada);

        $horaInicioFormateada = date('h:i A', strtotime($horaInicio));
        $horaFinFormateada = date('h:i A', strtotime($horaFin));

        // Construir el cuerpo del correo en HTML
        $mail->Body = generarPlantillaCorreoCita(
            $nombreEspecialista,
            $nombrePaciente,
            $fechaFormateada,
            $horaInicioFormateada,
            $horaFinFormateada,
            $servicio,
            $motivoConsulta
        );

        // Texto alternativo (para clientes que no soportan HTML)
        $mail->AltBody = "
Nueva Cita Agendada en E-VITALIX

Estimado(a) Dr(a). $nombreEspecialista,

Se ha agendado una nueva cita:

Paciente: $nombrePaciente
Fecha: $fechaFormateada
Hora: $horaInicioFormateada - $horaFinFormateada
Servicio: $servicio

Por favor, ingrese a la plataforma E-VITALIX para gestionar esta cita.

Saludos,
Sistema E-VITALIX
        ";

        // Enviar el correo
        $mail->send();

        // Log del envío exitoso
        error_log("Correo de notificación enviado a: $emailEspecialista");

        return true;
    } catch (Exception $e) {
        // Log del error
        error_log("Error al enviar correo de notificación: " . $e->getMessage());
        return false;
    }
}

/**
 * Traducir fecha del inglés al español
 * 
 * @param string $fecha Fecha en inglés
 * @return string Fecha en español
 */
function traducirFecha($fecha)
{
    $dias = [
        'Monday' => 'Lunes',
        'Tuesday' => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday' => 'Jueves',
        'Friday' => 'Viernes',
        'Saturday' => 'Sábado',
        'Sunday' => 'Domingo'
    ];

    $meses = [
        'January' => 'Enero',
        'February' => 'Febrero',
        'March' => 'Marzo',
        'April' => 'Abril',
        'May' => 'Mayo',
        'June' => 'Junio',
        'July' => 'Julio',
        'August' => 'Agosto',
        'September' => 'Septiembre',
        'October' => 'Octubre',
        'November' => 'Noviembre',
        'December' => 'Diciembre'
    ];

    $fecha = str_replace(array_keys($dias), array_values($dias), $fecha);
    $fecha = str_replace(array_keys($meses), array_values($meses), $fecha);

    return $fecha;
}

/**
 * Generar plantilla HTML para el correo de notificación
 */
function generarPlantillaCorreoCita(
    $nombreEspecialista,
    $nombrePaciente,
    $fecha,
    $horaInicio,
    $horaFin,
    $servicio,
    $motivoConsulta
) {
    return '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <title>Nueva Cita Agendada - E-VITALIX</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Nunito", sans-serif;
            background: linear-gradient(135deg, #e3f2fd 0%, #f5f5f5 100%);
            padding: 30px 15px;
            min-height: 100vh;
        }

        .email-wrapper {
            max-width: 650px;
            margin: 0 auto;
        }

        .email-container {
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 123, 255, 0.15);
        }

        .header {
            background: linear-gradient(135deg, #007bff 0%, #0c498a 100%);
            padding: 50px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: "";
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .logo-container {
            position: relative;
            z-index: 2;
            margin-bottom: 25px;
        }

        .logo {
            max-width: 200px;
            height: auto;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .header-title {
            position: relative;
            z-index: 2;
            color: #ffffff;
            font-size: 32px;
            font-weight: 800;
            margin: 0 0 10px 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-subtitle {
            position: relative;
            z-index: 2;
            color: rgba(255, 255, 255, 0.95);
            font-size: 16px;
            font-weight: 600;
        }

        .notification-badge {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: #ffffff;
            padding: 12px 30px;
            margin: -30px 40px 0;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            position: relative;
            z-index: 3;
        }

        .content {
            padding: 50px 40px;
        }

        .welcome-message {
            text-align: center;
            margin-bottom: 35px;
        }

        .welcome-message h2 {
            color: #0c498a;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .welcome-message p {
            color: #969696;
            font-size: 16px;
            line-height: 1.6;
        }

        .info-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border: 2px solid #e3f2fd;
            border-left: 5px solid #007bff;
            padding: 20px 25px;
            margin-bottom: 15px;
            border-radius: 15px;
            display: flex;
            align-items: center;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #007bff 0%, #1a73d3 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-size: 24px;
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            color: #969696;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .info-value {
            color: #0c498a;
            font-size: 18px;
            font-weight: 700;
        }

        .cita-destacada {
            background: linear-gradient(135deg, #e7f3ff 0%, #f0f8ff 100%);
            border: 3px solid #007bff;
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
        }

        .cita-icono {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #007bff 0%, #0c498a 100%);
            border-radius: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 35px;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .cita-titulo {
            color: #0c498a;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .cita-detalle {
            color: #333333;
            font-size: 16px;
            line-height: 1.8;
        }

        .motivo-section {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 20px;
            border-radius: 10px;
            margin-top: 25px;
        }

        .motivo-titulo {
            color: #856404;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .motivo-texto {
            color: #333333;
            font-size: 15px;
            line-height: 1.6;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #007bff 0%, #0c498a 100%);
            color: #ffffff;
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            margin-top: 30px;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
        }

        .footer {
            background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
            padding: 40px;
            text-align: center;
            border-top: 3px solid #007bff;
        }

        .footer-brand {
            margin-bottom: 20px;
        }

        .brand-name {
            color: #007bff;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
            display: block;
            margin-bottom: 5px;
        }

        .brand-tagline {
            color: #0c498a;
            font-size: 14px;
            font-weight: 600;
        }

        .footer-info {
            color: #969696;
            font-size: 14px;
            line-height: 1.8;
            margin-top: 15px;
        }

        @media (max-width: 600px) {
            body { padding: 15px 10px; }
            .header { padding: 35px 25px; }
            .header-title { font-size: 26px; }
            .content { padding: 35px 25px; }
            .notification-badge { margin: -25px 25px 0; padding: 10px 20px; font-size: 12px; }
            .info-card { flex-direction: column; text-align: center; }
            .info-icon { margin: 0 0 15px 0; }
            .cita-destacada { padding: 25px 20px; }
            .footer { padding: 30px 25px; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- HEADER -->
            <div class="header">
                <div class="logo-container">
                    <img src="https://raw.githubusercontent.com/CesarADSO/imagenes-evitalix/refs/heads/main/LOGO%20NEGATIVO.png" alt="E-VITALIX Logo" class="logo">
                </div>
                <h1 class="header-title">📅 Nueva Cita Agendada</h1>
                <p class="header-subtitle">Sistema de Gestión de Citas E-VITALIX</p>
            </div>

            <!-- BADGE DE NOTIFICACIÓN -->
            <div class="notification-badge">
                ✅ Nueva Solicitud de Cita
            </div>

            <!-- CONTENIDO -->
            <div class="content">
                <!-- MENSAJE DE BIENVENIDA -->
                <div class="welcome-message">
                    <h2>¡Hola, Dr(a). ' . htmlspecialchars($nombreEspecialista) . '!</h2>
                    <p>Se ha agendado una nueva cita en tu agenda. A continuación encontrarás los detalles:</p>
                </div>

                <!-- INFORMACIÓN DEL PACIENTE -->
                <div class="info-card">
                    <div class="info-icon">👤</div>
                    <div class="info-content">
                        <div class="info-label">Paciente</div>
                        <div class="info-value">' . htmlspecialchars($nombrePaciente) . '</div>
                    </div>
                </div>

                <!-- INFORMACIÓN DE FECHA -->
                <div class="info-card">
                    <div class="info-icon">📅</div>
                    <div class="info-content">
                        <div class="info-label">Fecha de la Cita</div>
                        <div class="info-value">' . $fecha . '</div>
                    </div>
                </div>

                <!-- INFORMACIÓN DE HORA -->
                <div class="info-card">
                    <div class="info-icon">🕐</div>
                    <div class="info-content">
                        <div class="info-label">Horario</div>
                        <div class="info-value">' . $horaInicio . ' - ' . $horaFin . '</div>
                    </div>
                </div>

                <!-- INFORMACIÓN DE SERVICIO -->
                <div class="info-card">
                    <div class="info-icon">🏥</div>
                    <div class="info-content">
                        <div class="info-label">Servicio Solicitado</div>
                        <div class="info-value">' . htmlspecialchars($servicio) . '</div>
                    </div>
                </div>

                <!-- SECCIÓN DESTACADA -->
                <div class="cita-destacada">
                    <div class="cita-icono">⏰</div>
                    <div class="cita-titulo">Estado de la Cita</div>
                    <div class="cita-detalle">
                        <strong>Pendiente de Confirmación</strong><br>
                        Por favor, ingresa a la plataforma para aceptar o cancelar esta cita.
                    </div>
                </div>

                ' . (!empty($motivoConsulta) ? '
                <!-- MOTIVO DE CONSULTA -->
                <div class="motivo-section">
                    <div class="motivo-titulo">📋 Motivo de Consulta</div>
                    <div class="motivo-texto">' . nl2br(htmlspecialchars($motivoConsulta)) . '</div>
                </div>
                ' : '') . '

                <!-- BOTÓN DE ACCIÓN -->
                <div style="text-align: center;">
                    <a href="http://localhost/E-VITALIX/especialista/mis-citas" class="cta-button">
                        Gestionar Cita
                    </a>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="footer">
                <div class="footer-brand">
                    <span class="brand-name">E-VITALIX</span>
                    <span class="brand-tagline">Sistema Inteligente de Gestión de Citas Médicas</span>
                </div>
                <div class="footer-info">
                    🔔 Notificación automática del sistema<br>
                    📧 No responder a este mensaje<br>
                    💻 Ingresa a la plataforma para gestionar tus citas
                </div>
            </div>
        </div>
    </div>
</body>
</html>
    ';
}
