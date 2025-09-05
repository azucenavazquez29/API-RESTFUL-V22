<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM actor WHERE actor_id=$id");
    header("Location: index.php");
}
?>