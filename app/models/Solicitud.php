<?php
class Solicitud {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function existeSolicitudActiva($usuarioId, $tallerId) {
        $stmt = $this->conn->prepare(
            "SELECT id FROM solicitudes WHERE usuario_id = ? AND taller_id = ? AND estado IN ('pendiente','aprobada')"
        );
        $stmt->bind_param("ii", $usuarioId, $tallerId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function crear($usuarioId, $tallerId) {
        $stmt = $this->conn->prepare(
            "INSERT INTO solicitudes (usuario_id, taller_id) VALUES (?, ?)"
        );
        $stmt->bind_param("ii", $usuarioId, $tallerId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function getPendientes() {
        $stmt = $this->conn->prepare(
            "SELECT s.id, s.fecha_solicitud, s.estado,
                    t.nombre AS taller, t.cupo_disponible,
                    u.username
             FROM solicitudes s
             JOIN talleres t ON s.taller_id = t.id
             JOIN usuarios u ON s.usuario_id = u.id
             WHERE s.estado = 'pendiente'
             ORDER BY s.fecha_solicitud ASC"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) $rows[] = $row;
        return $rows;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM solicitudes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function aprobar($id) {
        $stmt = $this->conn->prepare(
            "UPDATE solicitudes SET estado = 'aprobada' WHERE id = ? AND estado = 'pendiente'"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function rechazar($id) {
        $stmt = $this->conn->prepare(
            "UPDATE solicitudes SET estado = 'rechazada' WHERE id = ? AND estado = 'pendiente'"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}