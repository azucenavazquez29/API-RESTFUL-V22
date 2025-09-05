<?php
class Database {
    private $host = "localhost";
    private $db_name = "sakila";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            if ($this->conn->connect_errno) {
                throw new Exception("Error de conexión: " . $this->conn->connect_error);
            }
        } catch(Exception $e) {
            echo json_encode(["error" => $e->getMessage()]);
            exit;
        }
        return $this->conn;
    }
}
?>
