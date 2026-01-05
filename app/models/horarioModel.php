<?php
require_once __DIR__ . '/../../config/database.php';

// CREAMOS NUESTRA CLASE
class Horario
{
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }


    // CREAMOS EL METODO QUE VAMOS A UTILIZAR
    public function registrar($data)
    {
        // CREAMOS EL TRY-CATCH PARA MANEJAR ERRORES
        try {

            // GUARDAMOS EN UNA VARIABLE LA SENTENCIA SQL A EJECUTAR
            $registrar = "INSERT INTO disponibilidad_medico(id_especialista, id_consultorio, dia_semana, hora_inicio, hora_fin, pausa_inicio, pausa_fin, capacidad_maxima, duracion_slot, estado_disponibilidad) VALUES (:id_especialista, :id_consultorio, :dias, :horaInicio, :horaFin, :pausaInicio, :pausaFin, :capacidadMaxima, :duracion_cita, 'Activo')";

            $resultado = $this->conexion->prepare($registrar);

            $resultado->bindParam(':id_especialista', $data['id_especialista']);
            $resultado->bindParam(':id_consultorio', $data['id_consultorio']);
            $resultado->bindParam(':dias', $data['dias']);
            $resultado->bindParam(':horaInicio', $data['horaInicio']);
            $resultado->bindParam(':horaFin', $data['horaFin']);
            $resultado->bindParam(':pausaInicio', $data['inicioDescanso']);
            $resultado->bindParam(':pausaFin', $data['finDescanso']);
            $resultado->bindParam(':capacidadMaxima', $data['capacidadMaxima']);
            $resultado->bindParam(':duracion_cita', $data['duracion_cita']);

            $resultado->execute();

            // OBTENEMOS EL ID DE LA DISPONIBILIDAD
            $idDisponibilidad = $this->conexion->lastInsertId();

            // 🔹 ARMAMOS LA DISPONIBILIDAD COMPLETA
            $disponibilidad = [
                'id_disponibilidad' => $idDisponibilidad,
                'id_especialista' => $data['id_especialista'],
                'id_consultorio' => $data['id_consultorio'],
                'dia_semana' => $data['dias'],
                'hora_inicio' => $data['horaInicio'],
                'hora_fin' => $data['horaFin'],
                'pausa_inicio' => $data['inicioDescanso'],
                'pausa_fin' => $data['finDescanso'],
                'duracion_slot' => $data['duracion_cita']
            ];

            //  GENERAMOS LOS SLOTS
            $this->generarSlotsAutomaticos($disponibilidad);

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            // error_log('Error en Horario::registrar->' . $e->getMessage());
            return false;
        }
    }

    private function generarSlotsAutomaticos($disponibilidad)
    {
        // Convertimos el JSON de días en un array PHP
        // Ejemplo: ["Lunes","Martes","Miércoles"]
        $diasSemana = json_decode($disponibilidad['dia_semana'], true);

        // Mapeo correcto de días en español
        $mapaDias = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            7 => 'Domingo'
        ];

        // Fecha desde hoy
        $fechaInicio = new DateTime();


        // Generaremos slots para los próximos 30 días
        $fechaFin = (new DateTime())->modify('+30 days');

        // Recorremos día por día
        while ($fechaInicio <= $fechaFin) {

            // Día de la semana en número (1 a 7)
            $diaNumero = (int) $fechaInicio->format('N');

            // Obtenemos el nombre del día en español
            $diaActual = $mapaDias[$diaNumero];


            // Verificamos si el día actual está dentro de los días permitidos
            if (in_array($diaActual, $diasSemana)) {
                // Creamos DateTime con la fecha actual + hora inicio
                $horaInicio = new DateTime(
                    $fechaInicio->format('Y-m-d') . ' ' . $disponibilidad['hora_inicio']
                );

                // Hora final del turno
                $horaFin = new DateTime(
                    $fechaInicio->format('Y-m-d') . ' ' . $disponibilidad['hora_fin']
                );

                // Duración del slot en minutos
                $duracion = new DateInterval(
                    'PT' . $disponibilidad['duracion_slot'] . 'M'
                );

                // Horario de pausa
                $pausaInicio = new DateTime(
                    $fechaInicio->format('Y-m-d') . ' ' . $disponibilidad['pausa_inicio']
                );

                $pausaFin = new DateTime(
                    $fechaInicio->format('Y-m-d') . ' ' . $disponibilidad['pausa_fin']
                );

                // Generamos slots dentro del rango horario
                while ($horaInicio < $horaFin) {
                    // Calculamos la hora final del slot
                    $horaSlotFin = clone $horaInicio;
                    $horaSlotFin->add($duracion);

                    // Validamos que el slot NO esté dentro de la pausa
                    if ($horaSlotFin <= $pausaInicio || $horaInicio >= $pausaFin) {
                        // INSERTAMOS EL SLOT EN LA AGENDA

                        $slot = [
                            'id_disponibilidad' => $disponibilidad['id_disponibilidad'],
                            'id_especialista' => $disponibilidad['id_especialista'],
                            'id_consultorio' => $disponibilidad['id_consultorio'],
                            'fecha' => $fechaInicio->format('Y-m-d'),
                            'hora_inicio' => $horaInicio->format('H:i:s'),
                            'hora_fin' => $horaSlotFin->format('H:i:s')
                        ];

                        $this->insertarSlot($slot);
                    }

                    // Avanzamos al siguiente slot
                    $horaInicio->add($duracion);
                }
            }

            // pasamos al siguiente día
            $fechaInicio->modify('+1 day');
        }
    }

    private function insertarSlot($slot)
    {
        try {

            $insertarSlot = "INSERT INTO agenda_slot(id_disponibilidad, id_especialista, id_consultorio, fecha, hora_inicio, hora_fin, estado_slot) VALUES (:id_disponibilidad, :id_especialista, :id_consultorio, :fecha, :hora_inicio, :hora_fin, 'Disponible')";


            $resultado = $this->conexion->prepare($insertarSlot);


            $resultado->bindParam(':id_disponibilidad', $slot['id_disponibilidad']);
            $resultado->bindParam(':id_especialista', $slot['id_especialista']);
            $resultado->bindParam(':id_consultorio', $slot['id_consultorio']);
            $resultado->bindParam(':fecha', $slot['fecha']);
            $resultado->bindParam(':hora_inicio', $slot['hora_inicio']);
            $resultado->bindParam(':hora_fin', $slot['hora_fin']);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log('Error en Horario::insertarSlot->' . $e->getMessage());
            return false;
        }
    }

    public function mostrarParaElEspecialista($id_especialista)
    {
        try {

            // GUARDAMOS EN UNA VARIABLE LA CONSULTA SQL A EJECUTAR
            $mostrar = "SELECT * FROM disponibilidad_medico WHERE id_especialista = :id_especialista";

            $resultado = $this->conexion->prepare($mostrar);
            $resultado->bindParam(':id_especialista', $id_especialista);

            $resultado->execute();



            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log('Error en Horario::mostrar->' . $e->getMessage());
            return [];
        }
    }

    public function listarHorarioPorId($id)
    {
        // CREAMOS EL TRY-CATCH PARA MANEJAR ERRORES
        try {

            // GUARDAMOS EN UNA VARIABLE LA CONSULTA SQL QUE VAMOS A UTILIZAR
            $consultar = "SELECT disponibilidad_medico.*, especialistas.nombres AS nombre_especialista, especialistas.apellidos AS apellido_especialista, consultorios.nombre AS consultorio FROM disponibilidad_medico INNER JOIN especialistas ON disponibilidad_medico.id_especialista = especialistas.id INNER JOIN consultorios ON disponibilidad_medico.id_consultorio = consultorios.id WHERE disponibilidad_medico.id = :id";

            $resultado = $this->conexion->prepare($consultar);

            $resultado->bindParam(':id', $id);

            $resultado->execute();

            return $resultado->fetch();
        } catch (PDOException $e) {
            error_log('Error en Horario::listarHorariosPorId->' . $e->getMessage());
            return [];
        }
    }

    public function actualizar($data)
    {
        // CREAMOS EL TRY CATCH PARA MANEJAR ERRORES
        try {

            // GUARDAMOS EN UNA VARIABLE LA CONSULTA SQL A UTILIZAR
            $actualizar = "UPDATE disponibilidad_medico SET dia_semana = :dias, hora_inicio = :horaInicio, hora_fin = :horaFin, pausa_inicio = :pausaInicio, pausa_fin = :pausaFin, capacidad_maxima = :capacidadMaxima, estado_disponibilidad = :estado WHERE id = :id";

            $resultado = $this->conexion->prepare($actualizar);
            $resultado->bindParam(':id', $data['id']);
            $resultado->bindParam(':dias', $data['dias']);
            $resultado->bindParam(':horaInicio', $data['horaInicio']);
            $resultado->bindParam(':horaFin', $data['horaFin']);
            $resultado->bindParam(':pausaInicio', $data['inicioDescanso']);
            $resultado->bindParam(':pausaFin', $data['finDescanso']);
            $resultado->bindParam(':capacidadMaxima', $data['capacidadCitas']);
            $resultado->bindParam(':estado', $data['estado']);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log('Error en Horario::actualizar->' . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id)
    {
        try {


            $eliminarSlots = "DELETE FROM agenda_slot WHERE id_disponibilidad = :id_disponibilidad";

            $resultadoSlot = $this->conexion->prepare($eliminarSlots);

            $resultadoSlot-> bindParam(':id_disponibilidad', $id);

            $resultadoSlot->execute();

            $eliminar = "DELETE FROM disponibilidad_medico WHERE id = :id";

            $resultado = $this->conexion->prepare($eliminar);

            $resultado->bindParam(':id', $id);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log('Error en Horario::eliminar->' . $e->getMessage());
            return false;
        }
    }
}
