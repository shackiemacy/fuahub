<?php
session_start();
include 'db_config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $service = $_POST['service'];
    $options = isset($_POST['options']) ? json_decode($_POST['options'], true) : [];
    $quantities = isset($_POST['quantities']) ? json_decode($_POST['quantities'], true) : [];
    $total_price = $_POST['total_price'];

    // Insert booking into the database
    $sql = "INSERT INTO bookings (user_id, service_id, quantity, total_price, status) VALUES (?, ?, ?, ?, 'pending')";
    
    // You need to get the service_id from the service name
    $service_sql = "SELECT id FROM services WHERE name = ?";
    $stmt_service = $conn->prepare($service_sql);
    $stmt_service->bind_param("s", $service);
    $stmt_service->execute();
    $stmt_service->bind_result($service_id);
    $stmt_service->fetch();
    $stmt_service->close();

    $quantity = array_sum($quantities); // Total quantity for simplicity

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiid", $user_id, $service_id, $quantity, $total_price);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Service booked successfully!']);
    } else {
        echo json_encode(['error' => 'Error booking service: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
