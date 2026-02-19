<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS
// QUE ES LA CONEXIÓN A LA BASE DE DATOS
require_once __DIR__ . '/../../config/database.php';


class Ticket
{
    private $conexion;

    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function crear($data)
    {
        try {
            $crear = "INSERT INTO tickets (id_usuario, titulo, descripcion, imagen, estado) VALUES (:id_usuario, :titulo, :descripcion, :foto, 'ABIERTO')";
            $resultado = $this->conexion->prepare($crear);
            $resultado->bindParam(':id_usuario', $data['id_usuario']);
            $resultado->bindParam(':titulo', $data['titulo']);
            $resultado->bindParam(':descripcion', $data['descripcion']);
            $resultado->bindParam(':foto', $data['foto']);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en Ticket::crear->" . $e->getMessage());
            return false;
        }
    }

    // public function listarConUsuario() {
    //     $sql = "SELECT t.*, u.email, u.nombre 
    //             FROM tickets t
    //             INNER JOIN usuarios u ON t.usuario_id = u.id
    //             ORDER BY t.created_at DESC";
    //     return $this->db->query($sql);
    // }

    // public function responder($id, $respuesta) {
    //     $sql = "UPDATE tickets SET respuesta=?, estado='respondido' WHERE id=?";
    //     $stmt = $this->db->prepare($sql);
    //     return $stmt->execute([$respuesta, $id]);
    // }

    // public function obtenerPorId($id) {
    //     $sql = "SELECT t.*, u.email 
    //             FROM tickets t
    //             INNER JOIN usuarios u ON t.usuario_id = u.id
    //             WHERE t.id=?";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->execute([$id]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }
}
