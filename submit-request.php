<?php
// Submit service request (Store the request in the database)

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_type = $_POST['service-type'];
    $details = $_POST['details'];

    // Assuming user info is already stored in session or as part of the form submission
    $user_id = $_SESSION['user_id']; // Example for logged-in user

    // Database connection (make sure to replace with actual connection details)
    include 'db_connection.php';

    // Insert service request into the database
    $sql = "INSERT INTO service_requests (user_id, service_type, details, status) 
            VALUES ('$user_id', '$service_type', '$details', 'Pending')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Service request submitted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
