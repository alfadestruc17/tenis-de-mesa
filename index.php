<?php
require_once 'config/database.php';
require_once 'controllers/partido_controller.php';

$database = new Database();
$db = $database->connect();

$controller = new PartidoController($db);

$action = $_GET['action'] ?? 'index';

if ($action === 'store') {
    $controller->store();
} else {
    $controller->index();
}
