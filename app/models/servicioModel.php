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
}
