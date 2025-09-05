<?php
include 'config.php';

$result = $conn->query("SELECT * FROM actor ORDER BY actor_id ASC");
$actors = [];
while($row = $result->fetch_assoc()) {
    $actors[] = $row;
}
return $actors;
?>