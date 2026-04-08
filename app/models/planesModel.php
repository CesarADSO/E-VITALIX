<?php
require_once __DIR__ . '/../../config/database.php';

class Plan
{
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }
    
    // CREAMOS LA FUNCIÓN QUE NOS VA A TRAER LA INFORMACIÓN DE CADA PLAN PARA LOS APARTADOS DE PLAN
    public function traerId() {
        try {
            $mostrar = "SELECT id FROM planes_suscripcion";

            $resultado = $this->conexion->prepare($mostrar);
            $resultado->execute();

            return $resultado->fetchAll();

        } catch (PDOException $e) {
            error_log("Error en Plan::traerId->" . $e->getMessage());
            return [];
        }
    }

    // CREAMOS LA FUNCIÓN PARA TRAER EL RESUMEN DEL PLAN SELECCIONADO
    public function consultarPlanPorId($id_plan) {
        try {
            $consultar = "SELECT * FROM planes_suscripcion WHERE id = :id";
            $resultado = $this->conexion->prepare($consultar);
            $resultado->bindParam(':id', $id_plan);
            $resultado->execute();

            return $resultado->fetch();
        } catch (PDOException $e) {
            error_log("Error en Plan::consultarPlanPorId->" . $e->getMessage());
            return [];
        }
    }

    // CREAMOS LA FUNCIÓN PARA ACTUALIZAR EL PLAN AL CONSULTORIO
    public function actualizarPlanConsultorio($id_consultorio, $id_plan) {
        try {
            // CREAMOS LA QUERY PARA ACTUALIZAR EL PLAN DEL CONSULTORIO
            // AGREGAMOS EL CAMPOS fecha_vencimiento_plan, LA FUNCIÓN DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH) LO QUE HACE ES AGREAGARLE UN MES EJEMPLO SI HOY ES 26 DE MARZO AUTOMÁTICAMENTE AGREGAR EL 26 DE ABRIL
            $actualizarPlan = "UPDATE consultorios SET id_plan = :id_plan, fecha_vencimiento_plan = DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH) WHERE id = :id_consultorio";
            $resultado = $this->conexion->prepare($actualizarPlan);

            $resultado->bindParam(':id_plan', $id_plan);
            $resultado->bindParam(':id_consultorio', $id_consultorio);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en Plan::actualizarPlanConsultorio->" . $e->getMessage());
            return false;
        }
    }
}