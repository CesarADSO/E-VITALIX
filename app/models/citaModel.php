<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../helpers/mailer_helper.php';

class Cita
{
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function agendar($data)
    {
        try {
            $agendar = "INSERT INTO citas(id_agenda_slot, id_paciente, id_servicio, estado_cita) VALUES (:id_agenda_slot, :id_paciente, :id_servicio, 'Pendiente')";

            $resultado = $this->conexion->prepare($agendar);

            $resultado->bindParam(':id_agenda_slot', $data['id_slot']);
            $resultado->bindParam(':id_paciente', $data['id_paciente']);
            $resultado->bindParam(':id_servicio', $data['id_servicio']);

            $resultado->execute();

            // CAMBIAMOS EL ESTADO DEL SLOT A RESERVADO

            $cambiarEstadoSlot = "UPDATE agenda_slot SET estado_slot = 'Reservado' WHERE id = :id_agenda_slot";

            $resultado2 = $this->conexion->prepare($cambiarEstadoSlot);

            $resultado2->bindParam(':id_agenda_slot', $data['id_slot']);

            $resultado2->execute();

            // OBTENEMOS LOS DATOS DEL PACIENTE PARA INSERTARLOS EN EL CORREO ELECTRÓNICO
            $obtenerDatosPaciente = "SELECT pacientes.nombres, pacientes.apellidos, usuarios.email, pacientes.telefono, pacientes.numero_documento FROM pacientes INNER JOIN usuarios ON pacientes.id_usuario = usuarios.id WHERE pacientes.id = :id_paciente";

            $resultadoDatosPaciente = $this->conexion->prepare($obtenerDatosPaciente);
            $resultadoDatosPaciente->bindParam(':id_paciente', $data['id_paciente']);
            $resultadoDatosPaciente->execute();

            // OBTENEMOS LOS DATOS EN UN ARRAY
            $datosPaciente = $resultadoDatosPaciente->fetch();

            // GUARDAMOS LOS DATOS OBTENIDOS EN EL ARRAY data PARA USARLOS EN EL CORREO ELECTRÓNICO
            $data['nombrePaciente'] = $datosPaciente['nombres'] . ' ' . $datosPaciente['apellidos'];
            $data['emailPaciente'] = $datosPaciente['email'];
            $data['telefonoPaciente'] = $datosPaciente['telefono'];
            $data['documentoPaciente'] = $datosPaciente['numero_documento'];

            // OBTENEMOS LA FECHA Y HORA DE LA CITA PARA USARLOS EN EL CORREO ELECTRÓNICO
            $obtenerFechaHoraCita = "SELECT fecha, hora_inicio FROM agenda_slot WHERE id = :id_agenda_slot";
            $resultadoFechaHora = $this->conexion->prepare($obtenerFechaHoraCita);
            $resultadoFechaHora->bindParam(':id_agenda_slot', $data['id_slot']);
            $resultadoFechaHora->execute();

            // GUARDAMOS LOS DATOS EN UN ARRAY
            $fechaHoraCita = $resultadoFechaHora->fetch();

            // LOS GUARDAMOS EN DATA PARA LUEGO INSERTARLOS EN EL CORREO ELECTRÓNICO
            $data['fechaCita'] = $fechaHoraCita['fecha'];
            $data['horaCita'] = $fechaHoraCita['hora_inicio'];

            // OBTENEMOS EL EMAIL DEL ESPECIALISTA CON EL CUAL SE AGENDÓ LA CITA PARA PODER ENVIARLE UNA NOTIFICACIÓN POR CORREO ELECTRÓNICO

            $obtenerEmailEspecialista = "SELECT usuarios.email FROM agenda_slot INNER JOIN especialistas ON agenda_slot.id_especialista = especialistas.id INNER JOIN usuarios ON especialistas.id_usuario = usuarios.id WHERE agenda_slot.id = :id_agenda_slot";

            $resultadoEmail = $this->conexion->prepare($obtenerEmailEspecialista);
            $resultadoEmail->bindParam(':id_agenda_slot', $data['id_slot']);
            $resultadoEmail->execute();

            // OBTENGO SOLO EL EMAIL DEL ESPECIALISTA SIN ARRAYS SOLO EL STRING EJEMPLO: adriana@gmail.com PARA ESO USO EL fetchColumn
            $emailEspecialista = $resultadoEmail->fetchColumn();

            // LE ENVIAMOS EL CORREO AL ESPECIALISTA NOTIFICÁNDOLE QUE TIENE UNA NUEVA CITA PENDIENTE POR ACEPTAR
            // INICIALIZAR PHPMailer
            $mail = mailer_init(); // ← AQUÍ FALTABA EL PUNTO Y COMA ✔

            // EMISOR
            $mail->setFrom('evitalix558@gmail.com', 'Soporte E-VITALIX');

            // RECEPTOR
            $mail->addAddress($emailEspecialista);

            // ASUNTO
            $mail->Subject = "E-VITALIX - Solicitud de cita pendiente";

            // CUERPO HTML
            $mail->Body = '
                <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <title>E-VITALIX - Nueva Cita Agendada</title>
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
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
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
            background: linear-gradient(135deg, #007bff 0%, #1a73d3 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 40px;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3);
        }

        .alert-message h2 {
            color: #0c498a;
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .alert-message p {
            color: #969696;
            font-size: 16px;
            line-height: 1.8;
        }

        .patient-card {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border: 3px solid #007bff;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.15);
        }

        .patient-card h3 {
            color: #0c498a;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .patient-card h3::before {
            content: "👤";
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
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border: 3px solid #ff9800;
            border-radius: 20px;
            padding: 30px;
            margin: 25px 0;
            box-shadow: 0 6px 20px rgba(255, 152, 0, 0.15);
        }

        .appointment-details h3 {
            color: #e65100;
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

        .divider {
            height: 2px;
            background: linear-gradient(to right, transparent, #007bff, transparent);
            margin: 35px 0;
        }

        .info-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            border: 2px solid #007bff;
        }

        .info-box h3 {
            color: #0c498a;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .info-box p {
            color: #969696;
            font-size: 15px;
            line-height: 1.8;
        }

        .info-box-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #007bff 0%, #1a73d3 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 28px;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
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

            .patient-card, .appointment-details, .info-box {
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
                <h1 class="header-title">📋 Nueva Cita Agendada</h1>
                <p class="header-subtitle">Notificación de Cita Médica</p>
            </div>

            <!-- BADGE -->
            <div class="notification-badge">
                ✅ Cita Registrada
            </div>

            <!-- CONTENIDO -->
            <div class="content">
                <!-- MENSAJE DE ALERTA -->
                <div class="alert-message">
                    <div class="alert-icon">🔔</div>
                    <h2>¡Tienes una nueva cita agendada!</h2>
                    <p>Un paciente ha reservado una cita médica contigo. Revisa los detalles a continuación y prepárate para la consulta.</p>
                </div>

                <!-- INFORMACIÓN DEL PACIENTE -->
                <div class="patient-card">
                    <h3>Información del Paciente</h3>
                    
                    <div class="info-row">
                        <div class="info-row-icon">👤</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Nombre Completo</div>
                            <div class="info-row-value">' . htmlspecialchars($data['nombrePaciente']) . '</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon">📧</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Email</div>
                            <div class="info-row-value">' . htmlspecialchars($data['emailPaciente']) . '</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon">📞</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Teléfono</div>
                            <div class="info-row-value">' . htmlspecialchars($data['telefonoPaciente']) . '</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon">🆔</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Documento</div>
                            <div class="info-row-value">' . htmlspecialchars($data['documentoPaciente']) . '</div>
                        </div>
                    </div>
                </div>

                <!-- DETALLES DE LA CITA -->
                <div class="appointment-details">
                    <h3>Detalles de la Cita</h3>
                    
                    <div class="info-row">
                        <div class="info-row-icon">📅</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Fecha de la Cita</div>
                            <div class="info-row-value">' . htmlspecialchars($data['fechaCita']) . '</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon">⏰</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Hora de la Cita</div>
                            <div class="info-row-value">' . htmlspecialchars($data['horaCita']) . '</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon">🏥</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Tipo de Consulta</div>
                            <div class="info-row-value">' . htmlspecialchars($data['id_servicio']) . '</div>
                        </div>
                    </div>

                </div>

                <div class="divider"></div>

                <!-- INFORMACIÓN ADICIONAL -->
                <div class="info-box">
                    <div class="info-box-icon">💼</div>
                    <h3>Próximos Pasos</h3>
                    <p>Puedes gestionar esta cita desde tu panel de administración en la plataforma E-VITALIX. Inicia sesión para ver más detalles, aceptar o reprogramar la cita según sea necesario.</p>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="footer">
                <div class="footer-brand">
                    <span class="brand-name">E-VITALIX</span>
                    <span class="brand-tagline">Sistema Inteligente de Gestión Médica</span>
                </div>
                <div class="footer-info">
                    📅 Notificación de Cita Médica<br>
                    📧 Correo automático del sistema
                </div>
                <div class="footer-note">
                    Este es un correo informativo generado por E-VITALIX.<br>
                    Para gestionar tus citas, ingresa a tu panel de administración.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
            ';

            // ENVIAR CORREO
            $mail->send();


            return true;
        } catch (PDOException $e) {
            error_log("Error en Cita::agendar->" . $e->getMessage());
            return false;
        }
    }

    public function mostrar($id_paciente)
    {
        try {
            $consultar = "SELECT 
                    c.id AS id_cita,
                    a.fecha,
                    a.hora_inicio,
                    a.hora_fin,
                    c.estado_cita,
                    es.id AS id_especialidad,
                    e.nombres AS especialista_nombre,
                    es.nombre AS especialidad_nombre,
                    e.apellidos AS especialista_apellido,
                    s.id AS id_servicio,
                    s.nombre AS servicio_nombre,
                    co.id AS id_consultorio,
                    co.nombre AS nombre_consultorio,
                    co.ciudad, 
                    co.direccion,
                    s.precio AS servicio_precio
                FROM citas c
                INNER JOIN agenda_slot a ON c.id_agenda_slot = a.id
                INNER JOIN especialistas e ON a.id_especialista = e.id INNER JOIN especialidades es ON e.id_especialidad = es.id
                INNER JOIN consultorios co ON e.id_consultorio = co.id 
                INNER JOIN servicios s ON c.id_servicio = s.id
                WHERE c.id_paciente = :id_paciente
                ORDER BY a.fecha DESC, a.hora_inicio DESC";

            $resultado = $this->conexion->prepare($consultar);

            $resultado->bindParam(':id_paciente', $id_paciente);

            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en Cita::mostrar->" . $e->getMessage());
            return [];
        }
    }


    public function listarCita($id)
    {
        try {

            $listar = "SELECT citas.id AS id_cita, agenda_slot.id AS id_horario, agenda_slot.fecha, agenda_slot.hora_inicio, agenda_slot.hora_fin, especialistas.nombres, especialistas.apellidos, consultorios.nombre AS nombre_consultorio, servicios.id AS id_servicio, servicios.nombre AS nombre_servicio, citas.motivo_consulta FROM citas INNER JOIN agenda_slot ON citas.id_agenda_slot = agenda_slot.id INNER JOIN servicios ON citas.id_servicio = servicios.id INNER JOIN especialistas ON agenda_slot.id_especialista = especialistas.id INNER JOIN consultorios ON agenda_slot.id_consultorio = consultorios.id WHERE citas.id = :id_cita";

            $resultado = $this->conexion->prepare($listar);

            $resultado->bindParam(':id_cita', $id);

            $resultado->execute();

            return $resultado->fetch();
        } catch (PDOException $e) {
            error_log("Error en Cita::mostrar->" . $e->getMessage());
            return [];
        }
    }

    public function reagendar($data)
    {
        try {

            // INICIAMOS LA TRANSACCIÓN
            // ESTA LÍNEA DE CÓDIGO LO QUE HACE ES QUE LE DICE A PHP QUE VA A HACER VARIOS CAMBIOS IMPORTANTES ENTONCES QUE TODAVÍA NO GUARDE NADA PERMANENTEMENTE SINO QUE LO TENGA COMO EN "ESPERA"s
            $this->conexion->beginTransaction();

            // 1. OBTENER EL SLOT ANTERIOR DE LA CITA
            // ANTES DE CAMBIAR LA CITA, NECESITAMOS SABER QUE SLOT ESTABA RESERVADO
            $obtenerSlotAnterior = "SELECT id_agenda_slot FROM citas WHERE id = :id_cita";

            $resultadoSlotAnterior = $this->conexion->prepare($obtenerSlotAnterior);
            $resultadoSlotAnterior->bindParam(':id_cita', $data['id_cita']);
            $resultadoSlotAnterior->execute();


            // Guardamos el ID del slot anterior
            // fetchColumn devuelve SOLO el valor del id del slot anterior
            $slotAnterior = $resultadoSlotAnterior->fetchColumn();


            // ACTUALIZAR LA CITA CON EL NUEVO HORARIO


            $reagendar = "UPDATE citas SET id_agenda_slot = :id_slot WHERE id = :id_cita";

            $resultado = $this->conexion->prepare($reagendar);

            $resultado->bindParam(':id_slot', $data['id_slot']);
            $resultado->bindParam(':id_cita', $data['id_cita']);

            $resultado->execute();


            // LIBERAMOS EL SLOT ANTERIOR
            $liberarSlot = "UPDATE agenda_slot SET estado_slot = 'Disponible' WHERE id = :id_slot_anterior";

            $resultadoLiberar = $this->conexion->prepare($liberarSlot);
            $resultadoLiberar->bindParam(':id_slot_anterior', $slotAnterior);
            $resultadoLiberar->execute();

            // ACTUALIZAMOS EL NUEVO SLOT
            $cambiarEstadoSlot = "UPDATE agenda_slot SET estado_slot = 'Reservado' WHERE id = :id_slot";

            $resultado2 = $this->conexion->prepare($cambiarEstadoSlot);

            $resultado2->bindParam(':id_slot', $data['id_slot']);

            $resultado2->execute();

            // OBTENEMOS LOS DATOS DEL PACIENTE PARA INSERTARLOS EN EL CORREO ELECTRÓNICO
            $obtenerDatosPaciente = "SELECT pacientes.nombres, pacientes.apellidos, usuarios.email, pacientes.telefono, pacientes.numero_documento FROM pacientes INNER JOIN usuarios ON pacientes.id_usuario = usuarios.id WHERE pacientes.id = :id_paciente";

            $resultadoDatosPaciente = $this->conexion->prepare($obtenerDatosPaciente);
            $resultadoDatosPaciente->bindParam(':id_paciente', $data['id_paciente']);
            $resultadoDatosPaciente->execute();

            // OBTENEMOS LOS DATOS EN UN ARRAY
            $datosPaciente = $resultadoDatosPaciente->fetch();

            // GUARDAMOS LOS DATOS OBTENIDOS EN EL ARRAY data PARA USARLOS EN EL CORREO ELECTRÓNICO
            $data['nombrePaciente'] = $datosPaciente['nombres'] . ' ' . $datosPaciente['apellidos'];
            $data['emailPaciente'] = $datosPaciente['email'];
            $data['telefonoPaciente'] = $datosPaciente['telefono'];
            $data['documentoPaciente'] = $datosPaciente['numero_documento'];


            // OBTENEMOS LA FECHA Y LA HORA ORIGINALES DE LA CITA OSEA LA QUE YA ESTABA PROGRAMADA
            $obtenerFechaYhoraOriginal = "SELECT fecha, hora_inicio, hora_fin FROM agenda_slot WHERE id = :id_slot_anterior";
            $resultado3 = $this->conexion->prepare($obtenerFechaYhoraOriginal);
            $resultado3->bindParam(':id_slot_anterior', $slotAnterior);
            $resultado3->execute();

            $datosSlotOriginal = $resultado3->fetch();

            // GUARDAMOS LOS DATOS DEL SLOT ORIGINAL ANTES DE REAGENDAR EN DATA PARA USARLOS EN EL CORREO
            $data['fechaOriginal'] = $datosSlotOriginal['fecha'];
            $data['horaOriginal'] = $datosSlotOriginal['hora_inicio'] . ' ' . $datosSlotOriginal['hora_fin'];

            // OBTENEMOS LA NUEVA FECHA, HORA Y ESPECIALISTA DE LA CITA REPROGRAMADA
            $obtenerFechaHoraYEspecialista = "SELECT e.nombres, e.apellidos, u.email, a.fecha, a.hora_inicio, a.hora_fin FROM agenda_slot a INNER JOIN especialistas e ON a.id_especialista = e.id INNER JOIN usuarios u ON e.id_usuario = u.id WHERE a.id = :id_slot";

            $resultado4 = $this->conexion->prepare($obtenerFechaHoraYEspecialista);
            $resultado4->bindParam(':id_slot', $data['id_slot']);
            $resultado4->execute();

            $datosSlotNuevo = $resultado4->fetch();

            // GUARDAMOS LOS DATOS DEL SLOT NUEVO EN DATA PARA USARLOS EN EL CORREO
            $data['fechaNueva'] = $datosSlotNuevo['fecha'];
            $data['horaNueva'] = $datosSlotNuevo['hora_inicio'] . ' ' . $datosSlotNuevo['hora_fin'];
            $data['nuevoEspecialista'] = $datosSlotNuevo['nombres'] . ' ' . $datosSlotNuevo['apellidos'];
            $emailNuevoEspecialista = $datosSlotNuevo['email'];

            // OBTENEMOS EL CORREO DEL ESPECIALISTA DEL SLOT QUE ESTABA RESERVADO ANTES DE REPROGRAMAR LA CITA PARA ENVIARLE EL CORREO ELECTRÓNICO QUE SE MUESTRA A CONTINUACIÓN
            $obtenerCorreoEspecialistaAnterior = "SELECT u.email FROM agenda_slot a INNER JOIN especialistas e ON a.id_especialista = e.id INNER JOIN usuarios u ON e.id_usuario = u.id WHERE a.id = :id_slot_anterior";

            $resultado5 = $this->conexion->prepare($obtenerCorreoEspecialistaAnterior);
            $resultado5->bindParam(':id_slot_anterior', $slotAnterior);
            $resultado5->execute();

            $emailEspecialistaAnterior = $resultado5->fetchColumn();

            // OBTENEMOS EL NOMBRE DEL SERVICIO DE LA CITA PARA INSERTARLO EN EL SEGUNDO EMAIL
            $obtenerNombreServicio = "SELECT servicios.nombre FROM citas INNER JOIN servicios ON citas.id_servicio = servicios.id WHERE citas.id = :id_cita";
            $resultado6 = $this->conexion->prepare($obtenerNombreServicio);
            $resultado6->bindParam(':id_cita', $data['id_cita']);
            $resultado6->execute();

            $nombreServicio = $resultado6->fetchColumn();


            // ESTÁ LINEA LO QUE HACE ES DECIRLE A PHP QUE SI TODO SALIÓ BIEN GUARDE LOS DATOS PERMANENTEMENTE
            $this->conexion->commit();



            // INICIALIZAR PHPMailer
            $mail = mailer_init(); // ← AQUÍ FALTABA EL PUNTO Y COMA ✔

            // EMISOR
            $mail->setFrom('evitalix558@gmail.com', 'Soporte E-VITALIX');

            // RECEPTOR
            $mail->addAddress($emailEspecialistaAnterior);

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
    <title>E-VITALIX - Cita Reprogramada</title>
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
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
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
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
            color: #ffffff;
            padding: 12px 30px;
            margin: -30px 40px 0;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(255, 152, 0, 0.4);
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
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 40px;
            box-shadow: 0 6px 20px rgba(255, 152, 0, 0.3);
        }

        .alert-message h2 {
            color: #e65100;
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .alert-message p {
            color: #969696;
            font-size: 16px;
            line-height: 1.8;
        }

        .patient-card {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border: 3px solid #007bff;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.15);
        }

        .patient-card h3 {
            color: #0c498a;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .patient-card h3::before {
            content: "👤";
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

        .comparison-section {
            display: flex;
            gap: 20px;
            margin: 25px 0;
        }

        .comparison-card {
            flex: 1;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .old-data {
            background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
            border: 2px solid #f44336;
        }

        .old-data h4 {
            color: #c62828;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .old-data h4::before {
            content: "❌";
            margin-right: 8px;
            font-size: 18px;
        }

        .new-data {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            border: 2px solid #4caf50;
        }

        .new-data h4 {
            color: #2e7d32;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .new-data h4::before {
            content: "✅";
            margin-right: 8px;
            font-size: 18px;
        }

        .comparison-item {
            background-color: #ffffff;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .comparison-item:last-child {
            margin-bottom: 0;
        }

        .comparison-label {
            font-weight: 700;
            color: #666;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .comparison-value {
            color: #333;
            font-weight: 600;
            font-size: 15px;
        }

        .divider {
            height: 2px;
            background: linear-gradient(to right, transparent, #ff9800, transparent);
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

            .comparison-section {
                flex-direction: column;
                gap: 15px;
            }

            .patient-card, .info-box {
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
                <h1 class="header-title">🔄 Cita Reprogramada</h1>
                <p class="header-subtitle">Actualización de Agenda Médica</p>
            </div>

            <!-- BADGE -->
            <div class="notification-badge">
                🔄 Cita Modificada
            </div>

            <!-- CONTENIDO -->
            <div class="content">
                <!-- MENSAJE DE ALERTA -->
                <div class="alert-message">
                    <div class="alert-icon">⚠️</div>
                    <h2>Una cita ha sido reprogramada</h2>
                    <p>Te informamos que un paciente ha reprogramado su cita médica. La cita original contigo ha sido cancelada y reagendada con otro especialista.</p>
                </div>

                <!-- INFORMACIÓN DEL PACIENTE -->
                <div class="patient-card">
                    <h3>Información del Paciente</h3>
                    
                    <div class="info-row">
                        <div class="info-row-icon">👤</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Nombre Completo</div>
                            <div class="info-row-value">' . htmlspecialchars($data['nombrePaciente']) . '</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon">📧</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Email</div>
                            <div class="info-row-value">' . htmlspecialchars($data['emailPaciente']) . '</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon">🆔</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Documento</div>
                            <div class="info-row-value">' . htmlspecialchars($data['documentoPaciente']) . '</div>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- COMPARACIÓN DE CITAS -->
                <div class="comparison-section">
                    <!-- CITA ANTERIOR -->
                    <div class="comparison-card old-data">
                        <h4>Cita Cancelada</h4>
                        
                        <div class="comparison-item">
                            <div class="comparison-label">Fecha Original</div>
                            <div class="comparison-value">' . htmlspecialchars($data['fechaOriginal']) . '</div>
                        </div>

                        <div class="comparison-item">
                            <div class="comparison-label">Hora Original</div>
                            <div class="comparison-value">' . htmlspecialchars($data['horaOriginal']) . '</div>
                        </div>

                        <div class="comparison-item">
                            <div class="comparison-label">Especialista Original</div>
                            <div class="comparison-value">Tú</div>
                        </div>
                    </div>

                    <!-- CITA NUEVA -->
                    <div class="comparison-card new-data">
                        <h4>Nueva Cita</h4>
                        
                        <div class="comparison-item">
                            <div class="comparison-label">Nueva Fecha</div>
                            <div class="comparison-value">' . htmlspecialchars($data['fechaNueva']) . '</div>
                        </div>

                        <div class="comparison-item">
                            <div class="comparison-label">Nueva Hora</div>
                            <div class="comparison-value">' . htmlspecialchars($data['horaNueva']) . '</div>
                        </div>

                        <div class="comparison-item">
                            <div class="comparison-label">Nuevo Especialista</div>
                            <div class="comparison-value">' . htmlspecialchars($data['nuevoEspecialista']) . '</div>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- INFORMACIÓN ADICIONAL -->
                <div class="info-box">
                    <div class="info-box-icon">ℹ️</div>
                    <h3>Información</h3>
                    <p>Esta cita ha sido eliminada de tu agenda. El horario que tenías reservado para este paciente ahora está disponible para otras citas. Puedes verificar tu agenda actualizada en el panel de administración de E-VITALIX.</p>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="footer">
                <div class="footer-brand">
                    <span class="brand-name">E-VITALIX</span>
                    <span class="brand-tagline">Sistema Inteligente de Gestión Médica</span>
                </div>
                <div class="footer-info">
                    🔄 Notificación de Reprogramación<br>
                    📧 Correo automático del sistema
                </div>
                <div class="footer-note">
                    Este es un correo informativo generado por E-VITALIX.<br>
                    Tu agenda ha sido actualizada automáticamente.
                </div>
            </div>
        </div>
    </div>
</body>
</html>';

            // ENVIAR CORREO
            $mail->send();

            $mail->clearAddresses(); // Limpia el destinatario anterior


            // EMISOR
            $mail->setFrom('evitalix558@gmail.com', 'Soporte E-VITALIX');

            // RECEPTOR
            $mail->addAddress($emailNuevoEspecialista);

            // ASUNTO
            $mail->Subject = "E-VITALIX - Solicitud de cita pendiente";

            // CUERPO HTML
            $mail->Body = '
                <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <title>E-VITALIX - Nueva Cita Agendada</title>
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
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
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
            background: linear-gradient(135deg, #007bff 0%, #1a73d3 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 40px;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3);
        }

        .alert-message h2 {
            color: #0c498a;
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .alert-message p {
            color: #969696;
            font-size: 16px;
            line-height: 1.8;
        }

        .patient-card {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border: 3px solid #007bff;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.15);
        }

        .patient-card h3 {
            color: #0c498a;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .patient-card h3::before {
            content: "👤";
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
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border: 3px solid #ff9800;
            border-radius: 20px;
            padding: 30px;
            margin: 25px 0;
            box-shadow: 0 6px 20px rgba(255, 152, 0, 0.15);
        }

        .appointment-details h3 {
            color: #e65100;
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

        .divider {
            height: 2px;
            background: linear-gradient(to right, transparent, #007bff, transparent);
            margin: 35px 0;
        }

        .info-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            border: 2px solid #007bff;
        }

        .info-box h3 {
            color: #0c498a;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .info-box p {
            color: #969696;
            font-size: 15px;
            line-height: 1.8;
        }

        .info-box-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #007bff 0%, #1a73d3 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 28px;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
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

            .patient-card, .appointment-details, .info-box {
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
                <h1 class="header-title">📋 Nueva Cita Agendada</h1>
                <p class="header-subtitle">Notificación de Cita Médica</p>
            </div>

            <!-- BADGE -->
            <div class="notification-badge">
                ✅ Cita Registrada
            </div>

            <!-- CONTENIDO -->
            <div class="content">
                <!-- MENSAJE DE ALERTA -->
                <div class="alert-message">
                    <div class="alert-icon">🔔</div>
                    <h2>¡Tienes una nueva cita agendada!</h2>
                    <p>Un paciente ha reservado una cita médica contigo. Revisa los detalles a continuación y prepárate para la consulta.</p>
                </div>

                <!-- INFORMACIÓN DEL PACIENTE -->
                <div class="patient-card">
                    <h3>Información del Paciente</h3>
                    
                    <div class="info-row">
                        <div class="info-row-icon">👤</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Nombre Completo</div>
                            <div class="info-row-value">' . htmlspecialchars($data['nombrePaciente']) . '</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon">📧</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Email</div>
                            <div class="info-row-value">' . htmlspecialchars($data['emailPaciente']) . '</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon">📞</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Teléfono</div>
                            <div class="info-row-value">' . htmlspecialchars($data['telefonoPaciente']) . '</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon">🆔</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Documento</div>
                            <div class="info-row-value">' . htmlspecialchars($data['documentoPaciente']) . '</div>
                        </div>
                    </div>
                </div>

                <!-- DETALLES DE LA CITA -->
                <div class="appointment-details">
                    <h3>Detalles de la Cita</h3>
                    
                    <div class="info-row">
                        <div class="info-row-icon">📅</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Fecha de la Cita</div>
                            <div class="info-row-value">' . htmlspecialchars($data['fechaNueva']) . '</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon">⏰</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Hora de la Cita</div>
                            <div class="info-row-value">' . htmlspecialchars($data['horaNueva']) . '</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon">🏥</div>
                        <div class="info-row-content">
                            <div class="info-row-label">Tipo de Consulta</div>
                            <div class="info-row-value">' . htmlspecialchars($nombreServicio) . '</div>
                        </div>
                    </div>

                </div>

                <div class="divider"></div>

                <!-- INFORMACIÓN ADICIONAL -->
                <div class="info-box">
                    <div class="info-box-icon">💼</div>
                    <h3>Próximos Pasos</h3>
                    <p>Puedes gestionar esta cita desde tu panel de administración en la plataforma E-VITALIX. Inicia sesión para ver más detalles, aceptar o reprogramar la cita según sea necesario.</p>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="footer">
                <div class="footer-brand">
                    <span class="brand-name">E-VITALIX</span>
                    <span class="brand-tagline">Sistema Inteligente de Gestión Médica</span>
                </div>
                <div class="footer-info">
                    📅 Notificación de Cita Médica<br>
                    📧 Correo automático del sistema
                </div>
                <div class="footer-note">
                    Este es un correo informativo generado por E-VITALIX.<br>
                    Para gestionar tus citas, ingresa a tu panel de administración.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
            ';

            // ENVIAR EL CORREO
            $mail->send();

            return true;
        } catch (PDOException $e) {
            // SI ALGO FALLA DESHACEMOS TODO CON ESTÁS 3 LÍNEAS DE CÓDIGO
            // LO QUE HACEN LAS LÍNEAS QUE CONTIENEN EL IF ES QUE PRIMERO VALIDA SI HAY UNA TRANSACCIÓN EN CURSO Y SI LA HAY Y ALGO SALE MAL EJECUTA EL ROLLBACK QUE LO QUE HACE ES QUE DEJA LOS DATOS COMO ESTABAN ANTES.
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            error_log("Error en Cita::agendar->" . $e->getMessage());
            return false;
        }
    }

    public function cancelar($id)
    {
        try {

            $obtenerIdSlot = "SELECT id_agenda_slot FROM citas WHERE id = :id_cita";

            $resultado = $this->conexion->prepare($obtenerIdSlot);
            $resultado->bindParam(':id_cita', $id);
            $resultado->execute();

            // fetchColumn devuelve SOLO el valor del id del slot anterior
            $id_agenda_slot = $resultado->fetchColumn();

            if ($id_agenda_slot === false) {
                return false;
            }

            $cancelar = "UPDATE citas SET estado_cita = 'Cancelada' WHERE id = :id_cita";

            $resultado = $this->conexion->prepare($cancelar);

            $resultado->bindParam(':id_cita', $id);

            $resultado->execute();

            $cambiarEstadoSlot = "UPDATE agenda_slot SET estado_slot = 'Bloqueado' WHERE id = :id_agenda_slot";

            $resultado2 = $this->conexion->prepare($cambiarEstadoSlot);
            $resultado2->bindParam(':id_agenda_slot', $id_agenda_slot);
            $resultado2->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en Cita::cancelar->" . $e->getMessage());
            return false;
        }
    }
}
