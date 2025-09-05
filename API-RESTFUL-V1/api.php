<?php
// Configuración de conexión a la base de datos
$host = "localhost";
$user = "root";       // tu usuario
$pass = "";           // tu contraseña
$db   = "sakila";     // base de datos

$conexion = new mysqli($host, $user, $pass, $db);
if ($conexion->connect_errno) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión: " . $conexion->connect_error]);
    exit;
}

// Configurar cabeceras
header("Content-Type: application/json; charset=UTF-8");

// Detectar método y recurso
$method = $_SERVER['REQUEST_METHOD'];

// Intentar leer el recurso desde PATH_INFO o ?r=
$requestUri = $_SERVER['PATH_INFO'] ?? ($_GET['r'] ?? '');
$request = explode("/", trim($requestUri, "/"));

$resource = $request[0] ?? null;
$id = $request[1] ?? null;

if ($resource !== "actor") {
    http_response_code(404);
    echo json_encode(["error" => "Recurso no encontrado"]);
    exit;
}

// Métodos CRUD
switch ($method) {
    case 'GET':
        if ($id) {
            $sql = "SELECT * FROM actor WHERE actor_id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result()->fetch_assoc();
            echo json_encode($res ?: ["mensaje" => "No encontrado"]);
        } else {
            $sql = "SELECT * FROM actor";
            $res = $conexion->query($sql);
            echo json_encode($res->fetch_all(MYSQLI_ASSOC));
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["first_name"], $data["last_name"])) {
            http_response_code(400);
            echo json_encode(["error" => "Faltan campos"]);
            exit;
        }
        $sql = "INSERT INTO actor (first_name, last_name, last_update) VALUES (?, ?, NOW())";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $data["first_name"], $data["last_name"]);
        $stmt->execute();
        echo json_encode(["mensaje" => "Actor creado", "id" => $conexion->insert_id]);
        break;

    case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Falta ID"]);
            exit;
        }
        $data = json_decode(file_get_contents("php://input"), true);
        $sql = "UPDATE actor SET first_name = ?, last_name = ?, last_update = NOW() WHERE actor_id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssi", $data["first_name"], $data["last_name"], $id);
        $stmt->execute();
        echo json_encode(["mensaje" => "Actor actualizado"]);
        break;

    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Falta ID"]);
            exit;
        }
        $sql = "DELETE FROM actor WHERE actor_id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo json_encode(["mensaje" => "Actor eliminado"]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>