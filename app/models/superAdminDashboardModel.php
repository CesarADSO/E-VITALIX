<?php
require_once __DIR__ . '/../../config/database.php';

class SuperAdminDashboard
{
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    // 1. TOTAL DE CONSULTORIOS 
    public function contarConsultorios()
    {
        try {
            $contarConsultorios = " SELECT COUNT(id) AS total_consultorios FROM consultorios";
            $resultado = $this->conexion->prepare($contarConsultorios);
            $resultado->execute();

            return $resultado->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error en SuperAdminDashboard::contarConsultorios " . $e->getMessage());
            return [];
        }
    }

    // 2. TOTAL DE USUARIOS
    public function contarUsuarios()
    {
        try {
            $contarUsuarios = " SELECT COUNT(id) AS total_usuarios FROM usuarios";
            $resultado = $this->conexion->prepare($contarUsuarios);
            $resultado->execute();

            return $resultado->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error en SuperAdminDashboard::contarUsuarios " . $e->getMessage());
            return [];
        }
    }

    // 3. Especialidades activas
    public function contarEspecialidades()
    {
        try {
            $contarEspecialidades = " SELECT COUNT(id) AS total_especialidades FROM especialidades";
            $resultado = $this->conexion->prepare($contarEspecialidades);
            $resultado->execute();

            return $resultado->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error en SuperAdminDashboard::contarEspecialidades " . $e->getMessage());
            return [];
        }
    }

    // 4. Contar nuevos consultorios por mes
    public function contarNuevosConsultoriosPorMes() {
        try {
            $contar = "SELECT COUNT(id) AS nuevos_consultorios FROM consultorios WHERE MONTH(fecha_registro) = MONTH(CURDATE()) AND YEAR(fecha_registro) = YEAR(CURDATE())";

            $resultado = $this->conexion->prepare($contar);
            $resultado->execute();

            return $resultado->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error en SuperAdminDashboard::contarNuevosConsultoriosPorMes " . $e->getMessage());
            return [];
        }
    }

    // 5. Mostrar los últimos 5 consultorios registrados
    public function mostrarUltimosConsultorios() {
        try {
            $mostrar = "SELECT c.id,  c.nombre, c.estado, a.nombres, a.apellidos, ciu.nombre AS ciudad FROM administradores a LEFT JOIN consultorios c ON a.id_consultorio = c.id INNER JOIN ciudades ciu ON c.id_ciudad = ciu.id ORDER BY c.id DESC LIMIT 5";

            $resultado = $this->conexion->prepare($mostrar);
            $resultado->execute();

            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en SuperAdminDashboard::mostrarUltimosConsultorios " . $e->getMessage());
            return [];
        }
    }
}
