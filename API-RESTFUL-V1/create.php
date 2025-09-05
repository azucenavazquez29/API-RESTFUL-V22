<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $conn->query("INSERT INTO actor (first_name, last_name) VALUES ('$first_name', '$last_name')");
    header("Location: index.php");
}
?>