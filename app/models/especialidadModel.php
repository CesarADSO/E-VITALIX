<?php
require_once __DIR__ . '/../../config/database.php';

class Especialidad
{
    private $conexion;

    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function registrar($data) {
        try {
            $registrarEspecialidad = "INSERT INTO especialidades(id_consultorio, nombre, descripcion, estado) VALUES (:id_consultorio, :nombre, :descripcion, 'ACTIVA')";

            $resultado = $this->conexion->prepare($registrarEspecialidad);

            $resultado->bindParam(':id_consultorio', $data['id_consultorio']);
            $resultado->bindParam(':nombre', $data['nombre']);
            $resultado->bindParam(':descripcion', $data['descripcion']);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en Especialidad::registrar->" . $e->getMessage());
            return false;
        }
    }

    public function listar($id_consultorio) {
        try {
            $listarEspecialidades = "SELECT * FROM especialidades WHERE id_consultorio = :id_consultorio";
            $resultado = $this->conexion->prepare($listarEspecialidades);
            $resultado->bindParam(':id_consultorio', $id_consultorio);
            $resultado->execute();
            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Especialidad::listar->" . $e->getMessage());
            return [];
        }
    }
}
