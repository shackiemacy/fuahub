<?php
// Match client request with available service providers

// Get the service request from the database
$request_id = $_POST['request_id'];
include 'db_connection.php';

$sql = "SELECT * FROM service_requests WHERE request_id = '$request_id'";
$result = mysqli_query($conn, $sql);
$request = mysqli_fetch_assoc($result);

// Find providers who offer the requested service
$service_type = $request['service_type'];
$sql_providers = "SELECT * FROM service_providers WHERE service_type = '$service_type' AND status = 'Available'";
$providers = mysqli_query($conn, $sql_providers);

while ($provider = mysqli_fetch_assoc($providers)) {
    // Match the provider with the request (send notification to provider, etc.)
    echo "Provider found: " . $provider['name'];
}

// Close connection
mysqli_close($conn);
?>
