<?php
require_once __DIR__ . '/../../config/database.php';

class Usuario
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

            $claveEncriptada = password_hash($data ['contrasena'], PASSWORD_DEFAULT);

            $insertar = "INSERT INTO usuarios(email, contrasena, id_rol, estado) VALUES(:email, :contrasena, :rol, 'Activo')";

            $resultado = $this->conexion->prepare($insertar);
            $resultado->bindParam(':email', $data['email']);
            $resultado->bindParam(':contrasena', $claveEncriptada);
            $resultado->bindParam(':rol', $data['id_rol']);
       

            $resultado->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error en usuario::registrar->" . $e->getMessage());
            return false;
        }
    }



    public function consultar()
    {
        try {
            $sql = "SELECT u.id, u.email, u.contrasena, r.nombre AS rol, u.estado
                    FROM usuarios u
                    LEFT JOIN roles r ON u.id_rol = r.id
                    ORDER BY u.id ASC";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Usuario::consultar->" . $e->getMessage());
            return [];
        }
    }
}