<?php
$conn = new mysqli('localhost', 'root', '', 'FuaHub');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
