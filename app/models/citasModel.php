<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../helpers/mailer_helper.php';

class CitasModel
{
    private $conexion;

    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    /**
     * Obtener todas las citas de un especialista específico
     * @param int $id_especialista ID del especialista logueado
     * @return array Lista de citas con información completa
     */
    public function obtenerCitasPorEspecialista($id_especialista)
    {
        try {
            $consulta = "
                SELECT 
                    p.id AS id_paciente,
                    c.id AS id_cita,
                    a.fecha,
                    a.hora_inicio,
                    a.hora_fin,
                    p.foto AS foto_paciente,
                    c.estado_cita,
                    CONCAT(p.nombres, ' ', p.apellidos) AS nombre_paciente,
                    p.telefono AS telefono_paciente,
                    u.email AS email_paciente,
                    
                    s.nombre AS servicio_nombre,
                    s.duracion_minutos AS servicio_duracion,
                    
                    s.precio AS servicio_precio
                FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id
                INNER JOIN usuarios u ON p.id_usuario = u.id
                
                INNER JOIN servicios s ON c.id_servicio = s.id
                INNER JOIN agenda_slot a ON c.id_agenda_slot = a.id
                WHERE a.id_especialista = :id_especialista
                
                ORDER BY 
                    CASE 
                        WHEN c.estado_cita = 'PENDIENTE' THEN 1
                        WHEN c.estado_cita = 'CONFIRMADA' THEN 2
                        WHEN c.estado_cita = 'CANCELADA' THEN 3
                        
                        ELSE 4
                    END,
                    a.fecha DESC, 
                    a.hora_inicio DESC
                    
            ";

            $resultado = $this->conexion->prepare($consulta);
            $resultado->bindParam(':id_especialista', $id_especialista, PDO::PARAM_INT);
            $resultado->execute();

            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener citas: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerIdCita($id_cita, $id_paciente)
    {
        try {
            $obtenerIdCitaYPaciente = "SELECT pacientes.id AS id_paciente, citas.id AS id_cita FROM citas INNER JOIN pacientes ON citas.id_paciente = pacientes.id WHERE citas.id = :id_cita AND pacientes.id = :id_paciente";
            $resultado = $this->conexion->prepare($obtenerIdCitaYPaciente);
            $resultado->bindParam(':id_cita', $id_cita);
            $resultado->bindParam(':id_paciente', $id_paciente);
            $resultado->execute();

            return $resultado->fetch();
        } catch (PDOException $e) {
            error_log("Error al obtener ID de cita: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Actualizar el estado de una cita
     * @param int $id_cita ID de la cita
     * @param string $nuevo_estado Nuevo estado (CONFIRMADA, CANCELADA)
     * @param int $id_especialista ID del especialista (validación de seguridad)
     * @return array Resultado de la operación
     */
    public function actualizarEstadoCita($id_cita, $nuevo_estado, $id_especialista)
    {
        try {
            // Primero verificamos que la cita pertenece al especialista
            $verificar = "SELECT id FROM citas WHERE id = :id_cita AND id_especialista = :id_especialista";
            $stmt = $this->conexion->prepare($verificar);
            $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
            $stmt->bindParam(':id_especialista', $id_especialista, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                return [
                    'success' => false,
                    'message' => 'No tienes permisos para modificar esta cita'
                ];
            }

            // Actualizamos el estado
            $actualizar = "UPDATE citas SET estado = :estado WHERE id = :id_cita";
            $resultado = $this->conexion->prepare($actualizar);
            $resultado->bindParam(':estado', $nuevo_estado, PDO::PARAM_STR);
            $resultado->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
            $resultado->execute();

            return [
                'success' => true,
                'message' => 'Estado de la cita actualizado correctamente'
            ];
        } catch (PDOException $e) {
            error_log("Error al actualizar estado de cita: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al actualizar el estado de la cita'
            ];
        }
    }

    /**
     * Obtener detalles completos de una cita específica
     * @param int $id_cita ID de la cita
     * @param int $id_especialista ID del especialista (validación)
     * @return array|null Datos de la cita o null si no existe
     */
    public function obtenerDetalleCita($id_cita, $id_especialista)
    {
        try {
            $consulta = "
                SELECT 
                    c.*,
                    CONCAT(p.nombres, ' ', p.apellidos) AS nombre_paciente,
                    p.telefono AS telefono_paciente,
                    p.email AS email_paciente,
                    p.fecha_nacimiento,
                    s.nombre AS servicio_nombre,
                    s.duracion AS servicio_duracion,
                    s.precio AS servicio_precio
                FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id
                INNER JOIN servicios s ON c.id_servicio = s.id
                WHERE c.id = :id_cita AND c.id_especialista = :id_especialista
            ";

            $resultado = $this->conexion->prepare($consulta);
            $resultado->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
            $resultado->bindParam(':id_especialista', $id_especialista, PDO::PARAM_INT);
            $resultado->execute();

            return $resultado->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener detalle de cita: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Contar citas por estado para un especialista
     * @param int $id_especialista ID del especialista
     * @return array Conteo de citas por estado
     */
    public function contarCitasPorEstado($id_especialista)
    {
        $consulta = "
        SELECT 
            estado_cita,
            COUNT(*) AS total
        FROM citas
        INNER JOIN agenda_slot 
            ON citas.id_agenda_slot = agenda_slot.id
        WHERE agenda_slot.id_especialista = :id_especialista
        GROUP BY estado_cita
    ";

        $stmt = $this->conexion->prepare($consulta);
        $stmt->bindParam(':id_especialista', $id_especialista, PDO::PARAM_INT);
        $stmt->execute();

        $conteo = [
            'Pendiente' => 0,
            'Aceptada' => 0,
            'Cancelada' => 0,
            'Rechazada' => 0
        ];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $conteo[$fila['estado_cita']] = (int)$fila['total'];
        }

        return $conteo;
    }

    public function aceptarCita($id)
    {
        try {
            // INICIAMOS UNA TRANSACCIÓN
            $this->conexion->beginTransaction();

            $aceptarCita = "UPDATE citas SET estado_cita = 'CONFIRMADA' WHERE id = :id_cita";
            $resultado = $this->conexion->prepare($aceptarCita);
            $resultado->bindParam(':id_cita', $id);
            $resultado->execute();

            // IMPORTANTE FALTA ENVIO DE CORREO ELECTRÓNICO AL PACIENTE INFORMANDO QUE SE ACEPTO LA CITA
            // OBTENEMOS LOS DATOS QUE NECESITAMOS PARA ENVIAR EL CORREO
            $obtenerDatos = "SELECT especialistas.nombres, especialistas.apellidos, especialidades.nombre AS nombre_especialidad, consultorios.nombre AS nombre_consultorio, consultorios.ciudad, consultorios.direccion, agenda_slot.fecha, agenda_slot.hora_inicio, agenda_slot.hora_fin, servicios.nombre AS nombre_servicio, usuarios.email FROM citas INNER JOIN agenda_slot ON citas.id_agenda_slot = agenda_slot.id INNER JOIN servicios ON citas.id_servicio = servicios.id INNER JOIN especialistas ON agenda_slot.id_especialista = especialistas.id INNER JOIN especialidades ON especialistas.id_especialidad = especialidades.id INNER JOIN pacientes ON citas.id_paciente = pacientes.id INNER JOIN usuarios ON pacientes.id_usuario = usuarios.id INNER JOIN consultorios ON agenda_slot.id_consultorio = consultorios.id WHERE citas.id = :id_cita";

            $resultado2 = $this->conexion->prepare($obtenerDatos);
            $resultado2->bindParam(':id_cita', $id);
            $resultado2->execute();

            $datos = $resultado2->fetch();

            // GUARDAMOS LOS DATOS EN UNA VARIABLE DATA PARA LUEGO USARLOS EN EL CORREO ELECTRÓNICO
            // DATOS ESPECIALISTA
            $data['nombreEspecialista'] = $datos['nombres'] . ' ' . $datos['apellidos'];
            $data['especialidad'] = $datos['nombre_especialidad'];

            // DATOS CONSULTORIO
            $data['consultorio'] = $datos['nombre_consultorio'];
            $data['direccion'] = $datos['ciudad'] . ' - ' . $datos['direccion'];

            // DATOS CITA
            $data['fechaCita'] = $datos['fecha'];
            $data['horaCita'] = $datos['hora_inicio'] . ' - ' . $datos['hora_fin'];
            $data['tipoConsulta'] = $datos['nombre_servicio'];

            // EMAIL DEL PACIENTE
            $emailPaciente = $datos['email'];

            // SI TODO SALIÓ BIEN QUE SE FINALICE LA TRANSACCIÓN
            $this->conexion->commit();

            // INICIALIZAR PHPMailer
            $mail = mailer_init(); // ← AQUÍ FALTABA EL PUNTO Y COMA ✔

            // EMISOR
            $mail->setFrom('evitalix558@gmail.com', 'Soporte E-VITALIX');

            // RECEPTOR
            $mail->addAddress($emailPaciente);

            // ASUNTO
            $mail->Subject = "E-VITALIX - Solicitud de cita pendiente";

            // CUERPO HTML
            $mail->Body = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <title>E-VITALIX - Cita Confirmada</title>
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
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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

        .header::after {
            content: "";
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
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
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
            position: relative;
            z-index: 3;
        }

        .content {
            padding: 50px 40px;
        }

        .success-message {
            text-align: center;
            margin-bottom: 35px;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 40px;
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
        }

        .success-message h2 {
            color: #28a745;
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .success-message p {
            color: #969696;
            font-size: 16px;
            line-height: 1.8;
        }

        .doctor-card {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border: 3px solid #007bff;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.15);
        }

        .doctor-card h3 {
            color: #0c498a;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .doctor-card h3::before {
            content: "👨‍⚕️";
            margin-right: 12px;
            font-size: 24px;
        }

        .info-row {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: #ffffff;
            border-radius: 10px;
            margin-bottom: 12px;
            border-left: 4px solid #007bff;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-row-icon {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #007bff 0%, #1a73d3 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 16px;
            flex-shrink: 0;
        }

        .info-row-content {
            flex: 1;
        }

        .info-row-label {
            color: #0c498a;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-row-value {
            color: #333333;
            font-size: 16px;
            font-weight: 600;
        }

        .appointment-details {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            border: 3px solid #28a745;
            border-radius: 20px;
            padding: 30px;
            margin: 25px 0;
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.15);
        }

        .appointment-details h3 {
            color: #2e7d32;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .appointment-details h3::before {
            content: "📅";
            margin-right: 12px;
            font-size: 24px;
        }

        .confirmed-row {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: #ffffff;
            border-radius: 10px;
            margin-bottom: 12px;
            border-left: 4px solid #28a745;
        }

        .confirmed-row:last-child {
            margin-bottom: 0;
        }

        .confirmed-row-icon {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 16px;
            flex-shrink: 0;
        }

        .divider {
            height: 2px;
            background: linear-gradient(to right, transparent, #28a745, transparent);
            margin: 35px 0;
        }

        .instructions {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border-radius: 15px;
            padding: 30px;
            border: 2px solid #ff9800;
            margin: 25px 0;
        }

        .instructions h3 {
            color: #e65100;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .instructions h3::before {
            content: "📋";
            margin-right: 12px;
            font-size: 24px;
        }

        .instruction-list {
            list-style: none;
            padding: 0;
        }

        .instruction-item {
            color: #333333;
            font-size: 15px;
            padding: 12px 0 12px 40px;
            position: relative;
            line-height: 1.6;
            border-bottom: 1px solid rgba(255, 152, 0, 0.2);
        }

        .instruction-item:last-child {
            border-bottom: none;
        }

        .instruction-item::before {
            content: "✓";
            position: absolute;
            left: 10px;
            color: #ff9800;
            font-weight: 700;
            font-size: 18px;
        }

        .reminder-box {
            background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
            border: 2px solid #ffc107;
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
        }

        .reminder-box h4 {
            color: #856404;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }

        .reminder-box h4::before {
            content: "⚠️";
            margin-right: 10px;
            font-size: 20px;
        }

        .reminder-box p {
            color: #856404;
            font-size: 15px;
            line-height: 1.6;
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

        .footer-note {
            color: #969696;
            font-size: 12px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-style: italic;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px 10px;
            }

            .header {
                padding: 35px 25px;
            }

            .header-title {
                font-size: 26px;
            }

            .content {
                padding: 35px 25px;
            }

            .notification-badge {
                margin: -25px 25px 0;
                padding: 10px 20px;
                font-size: 12px;
            }

            .doctor-card, .appointment-details, .instructions, .reminder-box {
                padding: 25px 20px;
            }

            .footer {
                padding: 30px 25px;
            }
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
                <h1 class="header-title">✅ ¡Cita Confirmada!</h1>
                <p class="header-subtitle">Tu Atención Médica está Asegurada</p>
            </div>

            <!-- BADGE -->
            <div class="notification-badge">
                ✅ Cita Aceptada
            </div>

            <!-- CONTENIDO -->
            <div class="content">
                <!-- MENSAJE DE ÉXITO -->
                <div class="success-message">
                    <div class="success-icon">🎉</div>
                    <h2>¡Tu cita ha sido confirmada!</h2>
                    <p>Nos complace informarte que el especialista ha aceptado tu cita médica. Te esperamos en la fecha y hora programadas.</p>
                </div>

                <!-- INFORMACIÓN DEL ESPECIALISTA -->
                <div class="doctor-card">
                    <h3>Tu Especialista</h3>
                    
                    <div class="info-row">
                        <div class="info-row-icon">👨‍⚕️</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Nombre del Especialista</div>
                            <div class="info-row-value">' . htmlspecialchars($data['nombreEspecialista']) . '</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon">🏥</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Especialidad</div>
                            <div class="info-row-value">' . htmlspecialchars($data['especialidad']) . '</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon">📍</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Consultorio</div>
                            <div class="info-row-value">' . htmlspecialchars($data['consultorio']) . '</div>
                        </div>
                    </div>
                </div>

                <!-- DETALLES DE LA CITA -->
                <div class="appointment-details">
                    <h3>Detalles de tu Cita</h3>
                    
                    <div class="confirmed-row">
                        <div class="confirmed-row-icon">📅</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Fecha de la Cita</div>
                            <div class="info-row-value">' . htmlspecialchars($data['fechaCita']) . '</div>
                        </div>
                    </div>

                    <div class="confirmed-row">
                        <div class="confirmed-row-icon">⏰</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Hora de la Cita</div>
                            <div class="info-row-value">' . htmlspecialchars($data['horaCita']) . '</div>
                        </div>
                    </div>

                    <div class="confirmed-row">
                        <div class="confirmed-row-icon">🏥</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Tipo de Consulta</div>
                            <div class="info-row-value">' . htmlspecialchars($data['tipoConsulta']) . '</div>
                        </div>
                    </div>

                    <div class="confirmed-row">
                        <div class="confirmed-row-icon">📍</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Dirección</div>
                            <div class="info-row-value">' . htmlspecialchars($data['direccion']) . '</div>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- INSTRUCCIONES -->
                <div class="instructions">
                    <h3>Recomendaciones para tu Cita</h3>
                    <ul class="instruction-list">
                        <li class="instruction-item">Llega 10 minutos antes de tu cita</li>
                        <li class="instruction-item">Trae tu documento de identidad</li>
                        <li class="instruction-item">Si tienes exámenes previos, tráelos contigo</li>
                        <li class="instruction-item">Prepara una lista de preguntas o síntomas</li>
                        <li class="instruction-item">Trae tu carnet de seguro médico si aplica</li>
                    </ul>
                </div>

                <!-- RECORDATORIO -->
                <div class="reminder-box">
                    <h4>Recordatorio Importante</h4>
                    <p>Si necesitas cancelar o reprogramar tu cita, por favor házlo con al menos 24 horas de anticipación a través de la plataforma E-VITALIX. Esto permitirá que otros pacientes puedan usar ese horario.</p>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="footer">
                <div class="footer-brand">
                    <span class="brand-name">E-VITALIX</span>
                    <span class="brand-tagline">Sistema Inteligente de Gestión Médica</span>
                </div>
                <div class="footer-info">
                    ✅ Confirmación de Cita Médica<br>
                    📧 Correo automático del sistema
                </div>
                <div class="footer-note">
                    Este es un correo de confirmación generado por E-VITALIX.<br>
                    ¡Te esperamos en tu cita!
                </div>
            </div>
        </div>
    </div>
</body>
</html>';

        // ENVIAR CORREO
        $mail->send();



            return true;
        } catch (PDOException $e) {
            error_log("Error en CitasModel::aceptarCita->" . $e->getMessage());
            return false;
        }
    }

    public function cancelarCita($id)
    {
        try {
            // INICIAMOS UNA TRANSACCIÓN
            $this->conexion->beginTransaction();

            $cancelarCita = "UPDATE citas SET estado_cita = 'CANCELADA' WHERE id = :id_cita";
            $resultado = $this->conexion->prepare($cancelarCita);
            $resultado->bindParam(':id_cita', $id);
            $resultado->execute();

            // IMPORTANTE FALTA ENVÍO DE CORREO ELECTRONICO AL PACIENTE INFORMANDO QUE SE DECLINO LA CITA
            // OBTENEMOS LOS DATOS QUE NECESITAMOS PARA ENVIAR EL CORREO
            $obtenerDatos = "SELECT especialistas.nombres, especialistas.apellidos, especialidades.nombre AS nombre_especialidad, agenda_slot.fecha, agenda_slot.hora_inicio, agenda_slot.hora_fin, servicios.nombre AS nombre_servicio, usuarios.email FROM citas INNER JOIN agenda_slot ON citas.id_agenda_slot = agenda_slot.id INNER JOIN servicios ON citas.id_servicio = servicios.id INNER JOIN especialistas ON agenda_slot.id_especialista = especialistas.id INNER JOIN especialidades ON especialistas.id_especialidad = especialidades.id INNER JOIN pacientes ON citas.id_paciente = pacientes.id INNER JOIN usuarios ON pacientes.id_usuario = usuarios.id WHERE citas.id = :id_cita";

            $resultado2 = $this->conexion->prepare($obtenerDatos);
            $resultado2->bindParam(':id_cita', $id);
            $resultado2->execute();

            $datos = $resultado2->fetch();

            // GUARDAMOS LOS DATOS EN UNA VARIABLE DATA PARA LUEGO USARLOS EN EL CORREO ELECTRÓNICO
            // DATOS ESPECIALISTA
            $data['nombreEspecialista'] = $datos['nombres'] . ' ' . $datos['apellidos'];
            $data['especialidad'] = $datos['nombre_especialidad'];

            // DATOS CITA
            $data['fechaCita'] = $datos['fecha'];
            $data['horaCita'] = $datos['hora_inicio'] . ' - ' . $datos['hora_fin'];
            $data['tipoConsulta'] = $datos['nombre_servicio'];

            // EMAIL DEL PACIENTE
            $emailPaciente = $datos['email'];

            // FINALIZAMOS LA TRANSACCIÓN
            $this->conexion->commit();

            // INICIALIZAR PHPMailer
            $mail = mailer_init(); // ← AQUÍ FALTABA EL PUNTO Y COMA ✔

            // EMISOR
            $mail->setFrom('evitalix558@gmail.com', 'Soporte E-VITALIX');

            // RECEPTOR
            $mail->addAddress($emailPaciente);

            // ASUNTO
            $mail->Subject = "E-VITALIX - Solicitud de cita pendiente";

            // CUERPO HTML
            $mail->Body = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <title>E-VITALIX - Cita Cancelada</title>
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
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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

        .header::after {
            content: "";
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
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
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: #ffffff;
            padding: 12px 30px;
            margin: -30px 40px 0;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
            position: relative;
            z-index: 3;
        }

        .content {
            padding: 50px 40px;
        }

        .alert-message {
            text-align: center;
            margin-bottom: 35px;
        }

        .alert-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 40px;
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3);
        }

        .alert-message h2 {
            color: #c82333;
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .alert-message p {
            color: #969696;
            font-size: 16px;
            line-height: 1.8;
        }

        .doctor-card {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border: 3px solid #007bff;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.15);
        }

        .doctor-card h3 {
            color: #0c498a;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .doctor-card h3::before {
            content: "👨‍⚕️";
            margin-right: 12px;
            font-size: 24px;
        }

        .info-row {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: #ffffff;
            border-radius: 10px;
            margin-bottom: 12px;
            border-left: 4px solid #007bff;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-row-icon {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #007bff 0%, #1a73d3 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 16px;
            flex-shrink: 0;
        }

        .info-row-content {
            flex: 1;
        }

        .info-row-label {
            color: #0c498a;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-row-value {
            color: #333333;
            font-size: 16px;
            font-weight: 600;
        }

        .cancelled-details {
            background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
            border: 3px solid #dc3545;
            border-radius: 20px;
            padding: 30px;
            margin: 25px 0;
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.15);
        }

        .cancelled-details h3 {
            color: #c82333;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .cancelled-details h3::before {
            content: "❌";
            margin-right: 12px;
            font-size: 24px;
        }

        .cancelled-row {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: #ffffff;
            border-radius: 10px;
            margin-bottom: 12px;
            border-left: 4px solid #dc3545;
        }

        .cancelled-row:last-child {
            margin-bottom: 0;
        }

        .cancelled-row-icon {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 16px;
            flex-shrink: 0;
        }

        .divider {
            height: 2px;
            background: linear-gradient(to right, transparent, #dc3545, transparent);
            margin: 35px 0;
        }

        .info-box {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            border: 2px solid #ff9800;
        }

        .info-box h3 {
            color: #e65100;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .info-box p {
            color: #666;
            font-size: 15px;
            line-height: 1.8;
        }

        .info-box-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 28px;
            box-shadow: 0 4px 15px rgba(255, 152, 0, 0.3);
        }

        .apology-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px solid #6c757d;
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }

        .apology-box p {
            color: #495057;
            font-size: 15px;
            line-height: 1.8;
            font-style: italic;
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

        .footer-note {
            color: #969696;
            font-size: 12px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-style: italic;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px 10px;
            }

            .header {
                padding: 35px 25px;
            }

            .header-title {
                font-size: 26px;
            }

            .content {
                padding: 35px 25px;
            }

            .notification-badge {
                margin: -25px 25px 0;
                padding: 10px 20px;
                font-size: 12px;
            }

            .doctor-card, .cancelled-details, .info-box, .apology-box {
                padding: 25px 20px;
            }

            .footer {
                padding: 30px 25px;
            }
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
                <h1 class="header-title">❌ Cita Cancelada</h1>
                <p class="header-subtitle">Notificación Importante</p>
            </div>

            <!-- BADGE -->
            <div class="notification-badge">
                🚫 Cita Eliminada
            </div>

            <!-- CONTENIDO -->
            <div class="content">
                <!-- MENSAJE DE ALERTA -->
                <div class="alert-message">
                    <div class="alert-icon">😔</div>
                    <h2>Tu cita médica ha sido cancelada</h2>
                    <p>Lamentamos informarte que tu cita médica ha sido cancelada por el especialista. Te pedimos disculpas por cualquier inconveniente que esto pueda causar.</p>
                </div>

                <!-- MENSAJE DE DISCULPA -->
                <div class="apology-box">
                    <p>"Lamentamos los inconvenientes que esto pueda ocasionar. Te invitamos a agendar una nueva cita en la plataforma E-VITALIX con otro especialista o en un horario diferente."</p>
                </div>

                <!-- INFORMACIÓN DEL ESPECIALISTA -->
                <div class="doctor-card">
                    <h3>Especialista que Canceló</h3>
                    
                    <div class="info-row">
                        <div class="info-row-icon">👨‍⚕️</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Nombre del Especialista</div>
                            <div class="info-row-value">' . htmlspecialchars($data['nombreEspecialista']) . '</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon">🏥</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Especialidad</div>
                            <div class="info-row-value">' . htmlspecialchars($data['especialidad']) . '</div>
                        </div>
                    </div>
                </div>

                <!-- DETALLES DE LA CITA CANCELADA -->
                <div class="cancelled-details">
                    <h3>Detalles de la Cita Cancelada</h3>
                    
                    <div class="cancelled-row">
                        <div class="cancelled-row-icon">📅</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Fecha de la Cita</div>
                            <div class="info-row-value">' . htmlspecialchars($data['fechaCita']) . '</div>
                        </div>
                    </div>

                    <div class="cancelled-row">
                        <div class="cancelled-row-icon">⏰</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Hora de la Cita</div>
                            <div class="info-row-value">' . htmlspecialchars($data['horaCita']) . '</div>
                        </div>
                    </div>

                    <div class="cancelled-row">
                        <div class="cancelled-row-icon">🏥</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Tipo de Consulta</div>
                            <div class="info-row-value">' . htmlspecialchars($data['tipoConsulta']) . '</div>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- INFORMACIÓN ADICIONAL -->
                <div class="info-box">
                    <div class="info-box-icon">📅</div>
                    <h3>Agenda una Nueva Cita</h3>
                    <p>Te invitamos a ingresar a la plataforma E-VITALIX para agendar una nueva cita médica. Puedes elegir otro especialista o consultar la disponibilidad en diferentes horarios. Estamos aquí para atenderte.</p>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="footer">
                <div class="footer-brand">
                    <span class="brand-name">E-VITALIX</span>
                    <span class="brand-tagline">Sistema Inteligente de Gestión Médica</span>
                </div>
                <div class="footer-info">
                    ❌ Notificación de Cancelación<br>
                    📧 Correo automático del sistema
                </div>
                <div class="footer-note">
                    Este es un correo informativo generado por E-VITALIX.<br>
                    Si tienes dudas, contacta con soporte técnico.
                </div>
            </div>
        </div>
    </div>
</body>
</html>';

            // ENVIAR CORREO
            $mail->send();

            return true;
        } catch (PDOException $e) {
            // SI ALGO FALLA DESHACEMOS TODO CON ESTÁS 3 LÍNEAS DE CÓDIGO
            // LO QUE HACEN LAS LÍNEAS QUE CONTIENEN EL IF ES QUE PRIMERO VALIDA SI HAY UNA TRANSACCIÓN EN CURSO Y SI LA HAY Y ALGO SALE MAL EJECUTA EL ROLLBACK QUE LO QUE HACE ES QUE DEJA LOS DATOS COMO ESTABAN ANTES.
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            error_log("Error en CitasModel::cancelarCita->" . $e->getMessage());
            return false;
        }
    }
}
