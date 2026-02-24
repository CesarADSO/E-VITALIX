<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS
// QUE ES LA CONEXIÓN A LA BASE DE DATOS
require_once __DIR__ . '/../../config/database.php';

// CREAMOS LA CLASE
class Slot
{

    //PONEMOS LA CONEXIÓN PRIVADA
    private $conexion;

    // CREAMOS LA FUNCIÓN CONSTRUCTORA
    function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function mostrar($id_especialista)
    {
        try {
            $consultar = "SELECT agenda_slot.*, especialistas.nombres, especialistas.apellidos, consultorios.nombre AS nombre_consultorio FROM agenda_slot INNER JOIN especialistas ON agenda_slot.id_especialista = especialistas.id INNER JOIN consultorios ON agenda_slot.id_consultorio = consultorios.id WHERE agenda_slot.id_especialista = :id_especialista AND (agenda_slot.fecha > CURDATE() OR (agenda_slot.fecha = CURDATE() AND agenda_slot.hora_inicio > CURTIME() )) ORDER BY agenda_slot.fecha ASC, agenda_slot.hora_inicio ASC";

            $resultado = $this->conexion->prepare($consultar);

            $resultado->bindParam(':id_especialista', $id_especialista);

            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en Slot::mostrar->" . $e->getMessage());
            return [];
        }
    }

    public function mostrarParaTodos()
    {
        try {
            $consultar = "SELECT agenda_slot.*, especialistas.nombres, especialistas.apellidos, consultorios.nombre AS nombre_consultorio FROM agenda_slot INNER JOIN especialistas ON agenda_slot.id_especialista = especialistas.id INNER JOIN consultorios ON agenda_slot.id_consultorio = consultorios.id WHERE agenda_slot.estado_slot = 'Disponible' AND ( agenda_slot.fecha > CURDATE() OR (agenda_slot.fecha = CURDATE() AND agenda_slot.hora_inicio > CURTIME() )) ORDER BY agenda_slot.fecha ASC, agenda_slot.hora_inicio ASC";

            $resultado = $this->conexion->prepare($consultar);

            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en Slot::mostrar->" . $e->getMessage());
            return [];
        }
    }

    public function consultarNombreServicio($id_servicio) {
        try {
            $consulta = "SELECT nombre FROM servicios WHERE id = :id_servicio";
            $resultado = $this->conexion->prepare($consulta);

            $resultado->bindParam(':id_servicio', $id_servicio);

            $resultado->execute();

            return $resultado->fetch();

        } catch (PDOException $e) {
            error_log("Error en Slot::consultarNombreServicio-> " . $e->getMessage());
            return [];
        }
    }

    public function listarDisponibilidad($id_consultorio, $id_especialidad, $id_servicio)
    {
        try {
            $consulta = "SELECT servicios.nombre AS nombre_servicio, especialistas.foto AS foto_especialista, especialistas.nombres AS nombre_especialista, especialistas.apellidos AS apellidos_especialista, agenda_slot.id AS id_slot, agenda_slot.estado_slot, agenda_slot.fecha, agenda_slot.hora_inicio, agenda_slot.hora_fin FROM agenda_slot INNER JOIN especialistas ON agenda_slot.id_especialista = especialistas.id INNER JOIN especialidades ON especialistas.id_especialidad = especialidades.id INNER JOIN servicios ON servicios.id_especialidad = especialidades.id WHERE agenda_slot.id_consultorio = :id_consultorio AND especialidades.id = :id_especialidad AND servicios.id = :id_servicio AND agenda_slot.fecha >= CURDATE() AND agenda_slot.estado_slot = 'Disponible'";

            $resultado = $this->conexion->prepare($consulta);
            $resultado->bindParam(':id_consultorio', $id_consultorio);
            $resultado->bindParam(':id_especialidad', $id_especialidad);
            $resultado->bindParam(':id_servicio', $id_servicio);

            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en Slot::listarDisponibilidad-> " . $e->getMessage());
            return [];
        }
    }

    public function modificarEstado($id)
    {
        try {

            $mostrarEstado = "SELECT agenda_slot.estado_slot FROM agenda_slot WHERE id = :id";

            $resultado = $this->conexion->prepare($mostrarEstado);

            $resultado->bindParam(':id', $id);

            $resultado->execute();

            $slot = $resultado->fetch();

            $estadoActual = $slot['estado_slot'];

            // 2. Definir nuevo estado
            if ($estadoActual === 'Disponible') {
                $nuevoEstado = 'Bloqueado';
            } else {
                $nuevoEstado = 'Disponible';
            }

            $modificarEstado = "UPDATE agenda_slot SET estado_slot = :nuevoEstado WHERE id = :id";

            $resultadoEstado = $this->conexion->prepare($modificarEstado);

            $resultadoEstado->bindParam(':id', $id);
            $resultadoEstado->bindParam(':nuevoEstado', $nuevoEstado);

            $resultadoEstado->execute();


            return true;
        } catch (PDOException $e) {
            error_log("Error en Slot::modificarEstado->" . $e->getMessage());
            return false;
        }
    }
}
