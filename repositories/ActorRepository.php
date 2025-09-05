<?php
require_once __DIR__ . '/../config/database.php';

class ActorRepository {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $res = $this->conn->query("SELECT * FROM actor");
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM actor WHERE actor_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($first_name, $last_name) {
        $stmt = $this->conn->prepare("INSERT INTO actor (first_name, last_name, last_update) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $first_name, $last_name);
        $stmt->execute();
        return $this->conn->insert_id;
    }

    public function update($id, $first_name, $last_name) {
        $stmt = $this->conn->prepare("UPDATE actor SET first_name = ?, last_name = ?, last_update = NOW() WHERE actor_id = ?");
        $stmt->bind_param("ssi", $first_name, $last_name, $id);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM actor WHERE actor_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows;
    }
}
?>
