<?php
$host = "localhost"; // Database host
$username = "root"; // Database username
$password = ""; // Database password (default is empty for XAMPP/MAMP)
$dbname = "fua_hub"; // Name of your database

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
