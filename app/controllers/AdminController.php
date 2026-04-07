<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Solicitud.php';
require_once __DIR__ . '/../models/Taller.php';

class AdminController {
    private $solicitudModel;
    private $tallerModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->solicitudModel = new Solicitud($db);
        $this->tallerModel   = new Taller($db);
    }

    public function solicitudes() {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php?page=login');
            return;
        }
        require __DIR__ . '/../views/admin/solicitudes.php';
    }

    public function getSolicitudesJson() {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            return;
        }
        header('Content-Type: application/json');
        $solicitudes = $this->solicitudModel->getPendientes();
        echo json_encode($solicitudes);
    }

    public function aprobar() {
        header('Content-Type: application/json');
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            return;
        }

        $solicitudId = intval($_POST['id_solicitud'] ?? 0);

        try {
            $solicitud = $this->solicitudModel->getById($solicitudId);
            if (!$solicitud || $solicitud['estado'] !== 'pendiente') {
                echo json_encode(['success' => false, 'error' => 'Solicitud no válida o ya procesada']);
                return;
            }

            $taller = $this->tallerModel->getById($solicitud['taller_id']);
            if (!$taller || $taller['cupo_disponible'] <= 0) {
                echo json_encode(['success' => false, 'error' => 'Sin cupo disponible en el taller']);
                return;
            }

            if ($this->tallerModel->descontarCupo($solicitud['taller_id'])) {
                $this->solicitudModel->aprobar($solicitudId);
                echo json_encode(['success' => true, 'message' => 'Solicitud aprobada correctamente']);
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo descontar el cupo']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function rechazar() {
        header('Content-Type: application/json');
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            return;
        }

        $solicitudId = intval($_POST['id_solicitud'] ?? 0);

        if ($this->solicitudModel->rechazar($solicitudId)) {
            echo json_encode(['success' => true, 'message' => 'Solicitud rechazada']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al rechazar o ya fue procesada']);
        }
    }
}