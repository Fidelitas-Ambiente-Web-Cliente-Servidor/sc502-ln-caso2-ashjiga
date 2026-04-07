<?php
session_start();

require_once './app/controllers/UserController.php';
require_once './app/controllers/TallerController.php';
require_once './app/controllers/AdminController.php';
require_once './app/models/Taller.php';
require_once './app/models/Solicitud.php';
require_once './app/models/User.php';

$page   = $_GET['page']   ?? 'login';
$option = $_GET['option'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($option === "talleres_json") {
        $taller = new TallerController();
        $taller->getTalleresJson();
        exit;
    }

    if ($option === "solicitudes_json") {
        $admin = new AdminController();
        $admin->getSolicitudesJson();
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $postOption = $_POST['option'] ?? '';

    if ($postOption === "login") {
        (new UserController())->login();
        exit;
    }

    if ($postOption === "register") {
        (new UserController())->registro();
        exit;
    }

    if ($postOption === "logout") {
        (new UserController())->logout();
        exit;
    }

    if ($postOption === "solicitar") {
        (new TallerController())->solicitar();
        exit;
    }

    if ($postOption === "aprobar") {
        (new AdminController())->aprobar();
        exit;
    }

    if ($postOption === "rechazar") {
        (new AdminController())->rechazar();
        exit;
    }
}

switch ($page) {
    case "talleres":
        (new TallerController())->index();
        break;
    case "admin":
        (new AdminController())->solicitudes();
        break;
    case "logout":
        (new UserController())->logout();
        break;
    case "registro":
        (new UserController())->showRegistro();
        break;
    case "login":
    default:
        (new UserController())->showLogin();
        break;
}