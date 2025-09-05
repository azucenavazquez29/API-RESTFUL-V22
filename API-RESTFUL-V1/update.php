<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $conn->query("UPDATE actor SET first_name='$first_name', last_name='$last_name' WHERE actor_id=$id");
    header("Location: index.php");
}
?>