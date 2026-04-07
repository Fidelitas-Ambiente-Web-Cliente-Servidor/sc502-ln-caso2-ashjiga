<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Taller.php';
require_once __DIR__ . '/../models/Solicitud.php';

class TallerController {
    private $tallerModel;
    private $solicitudModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->tallerModel   = new Taller($db);
        $this->solicitudModel = new Solicitud($db);
    }

    public function index() {
        if (!isset($_SESSION['id'])) {
            header('Location: index.php?page=login');
            return;
        }
        require __DIR__ . '/../views/taller/listado.php';
    }

    public function getTalleresJson() {
        if (!isset($_SESSION['id'])) {
            echo json_encode([]);
            return;
        }
        header('Content-Type: application/json');
        $talleres = $this->tallerModel->getAllDisponibles();
        echo json_encode($talleres);
    }

    public function solicitar() {
        header('Content-Type: application/json');
        if (!isset($_SESSION['id'])) {
            echo json_encode(['success' => false, 'error' => 'Debes iniciar sesión']);
            return;
        }

        $tallerId  = intval($_POST['taller_id'] ?? 0);
        $usuarioId = $_SESSION['id'];

        if (!$tallerId) {
            echo json_encode(['success' => false, 'error' => 'Taller no válido']);
            return;
        }

        $taller = $this->tallerModel->getById($tallerId);
        if (!$taller || $taller['cupo_disponible'] <= 0) {
            echo json_encode(['success' => false, 'error' => 'El taller no tiene cupos disponibles']);
            return;
        }

        if ($this->solicitudModel->existeSolicitudActiva($usuarioId, $tallerId)) {
            echo json_encode(['success' => false, 'error' => 'Ya tienes una solicitud activa o aprobada para este taller']);
            return;
        }

        if ($this->solicitudModel->crear($usuarioId, $tallerId)) {
            echo json_encode(['success' => true, 'message' => 'Solicitud enviada. Pendiente de aprobación.']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al crear la solicitud']);
        }
    }
}