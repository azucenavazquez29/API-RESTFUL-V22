<?php
require_once __DIR__ . '/../repositories/ActorRepository.php';

class ActorController {
    public $repo;

    public function __construct() {
        $this->repo = new ActorRepository();
    }

    public function handleRequest($method, $id = null) {
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"), true);

        switch($method) {
            case 'GET':
                echo json_encode($id ? $this->repo->getById($id) ?: ["mensaje"=>"No encontrado"] : $this->repo->getAll());
                break;

            case 'POST':
                if(isset($data["first_name"], $data["last_name"])) {
                    $newId = $this->repo->create($data["first_name"], $data["last_name"]);
                    echo json_encode(["mensaje"=>"Actor creado","id"=>$newId,"actor"=>$this->repo->getById($newId)]);
                } else {
                    http_response_code(400);
                    echo json_encode(["error"=>"Faltan campos"]);
                }
                break;

            case 'PUT':
                if(!$id) { http_response_code(400); echo json_encode(["error"=>"Falta ID"]); exit; }
                if(isset($data["first_name"], $data["last_name"])) {
                    $this->repo->update($id, $data["first_name"], $data["last_name"]);
                    echo json_encode(["mensaje"=>"Actor actualizado","id"=>$id,"actor"=>$this->repo->getById($id)]);
                } else {
                    http_response_code(400);
                    echo json_encode(["error"=>"Faltan campos"]);
                }
                break;

            case 'DELETE':
                if(!$id) { http_response_code(400); echo json_encode(["error"=>"Falta ID"]); exit; }
                $this->repo->delete($id);
                echo json_encode(["mensaje"=>"Actor eliminado","id"=>$id]);
                break;

            default:
                http_response_code(405);
                echo json_encode(["error"=>"Método no permitido"]);
        }
    }
}
?>
