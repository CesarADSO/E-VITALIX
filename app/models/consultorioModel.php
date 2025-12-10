<?php
require_once __DIR__ . '/../../config/database.php';

class Consultorio
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
            $insertar = "INSERT INTO consultorios(nombre, direccion, foto, ciudad, telefono, correo_contacto, especialidades, horario_atencion, estado) VALUES(:nombre, :direccion, :foto, :ciudad, :telefono, :correo_contacto, :especialidades, :horario_atencion, 'Activo')";



            $resultado = $this->conexion->prepare($insertar);
            $resultado->bindParam(':nombre', $data['nombre']);
            $resultado->bindParam(':direccion', $data['direccion']);
            $resultado->bindParam(':foto', $data['foto']);
            $resultado->bindParam(':ciudad', $data['ciudad']);
            $resultado->bindParam(':telefono', $data['telefono']);
            $resultado->bindParam(':correo_contacto', $data['correo_contacto']);
            $resultado->bindParam(':especialidades', $data['especialidades']);
            $resultado->bindParam(':horario_atencion', $data['horario_atencion']);

            return $resultado->execute();
        } catch (PDOException $e) {
            error_log("Error en consultorio::registrar->" . $e->getMessage());
            return false;
        }
    }

    public function consultar()
    {
        try {
            // Variable que almacena la sentencia de sql a ejecutar
            $consultar = "SELECT consultorios.*, administradores.nombres, administradores.apellidos FROM consultorios LEFT JOIN administradores ON consultorios.id_administrador = administradores.id ORDER BY consultorios.nombre ASC";
            // Preparar lo necesario para ejecutar la función

            $resultado = $this->conexion->prepare($consultar);

            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en consultorio::consultar->" . $e->getMessage());
            return [];
        }
    }

    public function listarConsultorioPorId($id)
    {
        try {
            // EN UNA VARIABLE GUARDAMOS LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO
            $consulta = "SELECT * FROM consultorios WHERE id = :id LIMIT 1";

            $resultado = $this->conexion->prepare($consulta);

            $resultado->bindParam(':id', $id);

            $resultado->execute();

            return $resultado->fetch();
        } catch (PDOException $e) {
            error_log("Error en consultorio::consultar->" . $e->getMessage());
            return [];
        }
    }

    public function actualizar($data)
    {
        try {
            $actualizar = "UPDATE consultorios SET nombre = :nombre, direccion = :direccion, ciudad = :ciudad, telefono = :telefono, correo_contacto = :correo_contacto, especialidades = :especialidades, horario_atencion = :horario_atencion, estado = :estado WHERE id = :id";

            $resultado = $this->conexion->prepare($actualizar);
            $resultado->bindParam(':id', $data['id']);
            $resultado->bindParam(':nombre', $data['nombre']);
            $resultado->bindParam(':ciudad', $data['ciudad']);
            $resultado->bindParam(':direccion', $data['direccion']);
            $resultado->bindParam(':telefono', $data['telefono']);
            $resultado->bindParam(':correo_contacto', $data['correo_contacto']);
            $resultado->bindParam(':especialidades', $data['especialidades']);
            $resultado->bindParam(':horario_atencion', $data['horario_atencion']);
            $resultado->bindParam(':estado', $data['estado']);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en consultorio::actualizar->" . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id)
    {
        try {
            $eliminar = "DELETE FROM consultorios WHERE id = :id";
            $resultado = $this->conexion->prepare($eliminar);
            $resultado->bindParam(':id', $id);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en consultorio::eliminar->" . $e->getMessage());
            return false;
        }
    }

    public function asignarAdministrador($data)
    {
        try {
            $asignar = "UPDATE consultorios SET id_administrador = :id_administrador WHERE id = :id";

            $resultado = $this->conexion->prepare($asignar);
            $resultado->bindParam(':id', $data['id']);
            $resultado->bindParam(':id_administrador', $data['administrador']);

            $resultado->execute();

            return true;

        } catch (PDOException $e) {
            error_log("Error en consultorio::asignarAdministrador->" . $e->getMessage());
            return false;
        }
    }

    public function desasignarAdminConsultorio($id) {
        try {
            $desasignar = "UPDATE consultorios SET id_administrador = null WHERE id = :id";

            $resultado = $this->conexion->prepare($desasignar);

            $resultado->bindParam(':id', $id);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en consultorio::desasignarAdminConsultorio->" . $e->getMessage());
            return false;
        }
    }
}
