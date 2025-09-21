<?php
// Update the service provider’s service offerings (Availability & Price)

// Assuming user info is stored in session
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vacuum_price = $_POST['vacuum-cleaning-price'];
    $vacuum_status = $_POST['vacuum-cleaning-status'];

    // Update the database with the service details
    include 'db_connection.php';

    $sql = "UPDATE service_providers SET vacuum_price = '$vacuum_price', vacuum_status = '$vacuum_status'
            WHERE user_id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        echo "Service details updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
