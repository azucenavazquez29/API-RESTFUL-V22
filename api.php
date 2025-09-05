<?php
require_once 'controllers/ActorController.php';

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['PATH_INFO'] ?? ($_GET['r'] ?? '');
$request = explode("/", trim($requestUri, "/"));

$resource = $request[0] ?? null;
$id = $request[1] ?? null;

if($resource !== "actor") {
    http_response_code(404);
    echo json_encode(["error"=>"Recurso no encontrado"]);
    exit;
}

$controller = new ActorController();
$controller->handleRequest($method, $id);
?>
