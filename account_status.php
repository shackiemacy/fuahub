<?php
session_start();
header('Content-Type: application/json');

// Simulate checking if the user has signed up
include 'db_connection.php';

$userId = $_SESSION['user_id'] ?? null;
if ($userId) {
    $query = "SELECT id FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['status' => 'active']);
    } else {
        echo json_encode(['status' => 'inactive']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'inactive']);
}

$conn->close();
?>
