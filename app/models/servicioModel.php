<?php
require_once __DIR__ . '/../../config/database.php';

class Servicio
{
    private $conexion;

    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function registrar($data)
    {
        try {
            $registrar = "INSERT INTO servicios (
                    nombre,
                    descripcion,
                    id_especialista,
                    id_consultorio,
                    duracion_minutos,
                    precio,
                    id_metodo_pago,
                    estado_servicio,
                    codigo_servicio
                ) VALUES (
                    :nombre,
                    :descripcion,
                    :id_especialista,
                    :id_consultorio,
                    :duracion_minutos,
                    :precio,
                    :id_metodo_pago,
                    'Activo',
                    :codigo_servicio
                )";

            $resultado = $this->conexion->prepare($registrar);

            $resultado->bindParam(':nombre', $data['nombre']);
            $resultado->bindParam(':descripcion', $data['descripcion']);
            $resultado->bindParam(':id_especialista', $data['id_especialista']);
            $resultado->bindParam(':id_consultorio', $data['id_consultorio']);
            $resultado->bindParam(':duracion_minutos', $data['duracion_minutos']);
            $resultado->bindParam(':precio', $data['precio']);
            $resultado->bindParam(':id_metodo_pago', $data['id_metodo_pago']);
            $resultado->bindParam(':codigo_servicio', $data['codigo_servicio']);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en Servicio::registrar -> " . $e->getMessage());
            return false;
        }
    }

    public function mostrar($id_consultorio) {
        try {
            $consultar = "SELECT servicios.*, especialistas.nombres AS nombre_especialista, especialistas.apellidos AS apellido_especialista, consultorios.nombre AS nombre_consultorio, metodos_pago.nombre AS nombre_metodo_pago FROM servicios INNER JOIN especialistas ON servicios.id_especialista = especialistas.id INNER JOIN consultorios ON servicios.id_consultorio = consultorios.id INNER JOIN metodos_pago ON servicios.id_metodo_pago = metodos_pago.id WHERE servicios.id_consultorio = :id_consultorio";


            $resultado = $this->conexion->prepare($consultar);
            $resultado->bindParam(':id_consultorio', $id_consultorio);
            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en Servicio::mostrar -> " . $e->getMessage());
            return [];
        }
    }

    public function listarServicio($id) {
        try {
            $mostrarServicio = "SELECT servicios.id, servicios.descripcion, servicios.duracion_minutos, servicios.precio, servicios.id_metodo_pago, metodos_pago.nombre AS metodo_pago, servicios.estado_servicio FROM servicios INNER JOIN metodos_pago ON servicios.id_metodo_pago = metodos_pago.id WHERE servicios.id = :id";

            $resultado = $this->conexion->prepare($mostrarServicio);

            $resultado->bindParam(':id', $id);

            $resultado->execute();

            return $resultado->fetch();
        } catch (PDOException $e) {
            error_log("Error en Servicio::listarServicio -> " . $e->getMessage());
            return [];
        }
    }

    public function actualizar($data) {
        try {
            $actualizar = "UPDATE servicios SET descripcion = :descripcion, duracion_minutos = :duracion_minutos, precio = :precio, id_metodo_pago = :id_metodo_pago, estado_servicio = :estado_servicio WHERE id = :id";

            $resultado = $this->conexion->prepare($actualizar);

            $resultado->bindParam(':id', $data['id']);
            $resultado->bindParam(':descripcion', $data['descripcion']);
            $resultado->bindParam(':duracion_minutos', $data['duracion_minutos']);
            $resultado->bindParam(':precio', $data['precio']);
            $resultado->bindParam(':id_metodo_pago', $data['id_metodo_pago']);
            $resultado->bindParam(':estado_servicio', $data['estado']);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en Servicio::actualizar -> " . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id) {
        try {
            $eliminar = "DELETE FROM servicios WHERE id = :id";

            $resultado = $this->conexion->prepare($eliminar);

            $resultado->bindParam(':id', $id);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en Servicio::eliminar -> " . $e->getMessage());
            return false;
        }
    }
}
