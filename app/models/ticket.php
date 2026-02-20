<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS
// QUE ES LA CONEXIÓN A LA BASE DE DATOS
require_once __DIR__ . '/../../config/database.php';


class Ticket {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function crear($usuario_id, $titulo, $descripcion, $imagen) {
        $sql = "INSERT INTO tickets (usuario_id, titulo, descripcion, imagen)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$usuario_id, $titulo, $descripcion, $imagen]);
    }

    public function listarConUsuario() {
        $sql = "SELECT t.*, u.email, u.nombre 
                FROM tickets t
                INNER JOIN usuarios u ON t.usuario_id = u.id
                ORDER BY t.created_at DESC";
        return $this->db->query($sql);
    }

    public function responder($id, $respuesta) {
        $sql = "UPDATE tickets SET respuesta=?, estado='respondido' WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$respuesta, $id]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT t.*, u.email 
                FROM tickets t
                INNER JOIN usuarios u ON t.usuario_id = u.id
                WHERE t.id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>