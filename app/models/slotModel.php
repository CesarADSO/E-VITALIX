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
            $consultar = "SELECT agenda_slot.*, especialistas.nombres, especialistas.apellidos, consultorios.nombre AS nombre_consultorio FROM agenda_slot INNER JOIN especialistas ON agenda_slot.id_especialista = especialistas.id INNER JOIN consultorios ON agenda_slot.id_consultorio = consultorios.id WHERE agenda_slot.id_especialista = :id_especialista ORDER BY agenda_slot.fecha ASC";

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
            $consultar = "SELECT agenda_slot.*, especialistas.nombres, especialistas.apellidos, consultorios.nombre AS nombre_consultorio FROM agenda_slot INNER JOIN especialistas ON agenda_slot.id_especialista = especialistas.id INNER JOIN consultorios ON agenda_slot.id_consultorio = consultorios.id ORDER BY agenda_slot.fecha ASC";

            $resultado = $this->conexion->prepare($consultar);

            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en Slot::mostrar->" . $e->getMessage());
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
                $nuevoEstado = 'Reservado';
            } elseif ($estadoActual === 'Reservado') {
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
