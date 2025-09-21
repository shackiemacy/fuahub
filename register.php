<?php
session_start();
include 'db_connection.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];

$sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $username, $email, $password, $role);

if ($stmt->execute()) {
    $_SESSION['user_id'] = $conn->insert_id; // Set user ID in session
    echo "Successfully signed up!";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>


