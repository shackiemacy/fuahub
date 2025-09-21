<?php
// Database setup script
include 'db_connection.php';

// Create users table if it doesn't exist
$createUsersTable = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('client', 'service_provider') NOT NULL DEFAULT 'client',
    phone VARCHAR(15) NULL,
    location VARCHAR(100) NULL,
    experience ENUM('beginner', 'intermediate', 'experienced') NULL,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($createUsersTable) === TRUE) {
    echo "Users table created successfully or already exists.<br>";
} else {
    echo "Error creating users table: " . $conn->error . "<br>";
}

// Create services table if it doesn't exist
$createServicesTable = "
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    base_price DECIMAL(10,2) NOT NULL,
    category VARCHAR(50),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($createServicesTable) === TRUE) {
    echo "Services table created successfully or already exists.<br>";
} else {
    echo "Error creating services table: " . $conn->error . "<br>";
}

// Create bookings table if it doesn't exist
$createBookingsTable = "
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_id INT NOT NULL,
    provider_id INT NULL,
    quantity INT DEFAULT 1,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'confirmed', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    service_date DATETIME NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
    FOREIGN KEY (provider_id) REFERENCES users(id) ON DELETE SET NULL
)";

if ($conn->query($createBookingsTable) === TRUE) {
    echo "Bookings table created successfully or already exists.<br>";
} else {
    echo "Error creating bookings table: " . $conn->error . "<br>";
}

// Insert default services if they don't exist
$services = [
    ['Vacuum Cleaning', 'Professional vacuum cleaning for carpets, rugs, and upholstery', 200.00, 'cleaning'],
    ['Ironing', 'Professional ironing service for all types of clothing', 10.00, 'laundry'],
    ['Washing Clothes', 'Complete laundry service including washing, rinsing, and drying', 500.00, 'laundry'],
    ['Washing Dishes', 'Professional dishwashing service for your kitchen', 250.00, 'cleaning'],
    ['Mopping', 'Professional floor cleaning and mopping service', 70.00, 'cleaning'],
    ['Cooking', 'Professional cooking service for your meals', 350.00, 'cooking']
];

foreach ($services as $service) {
    $checkService = "SELECT id FROM services WHERE name = ?";
    $checkStmt = $conn->prepare($checkService);
    $checkStmt->bind_param("s", $service[0]);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows == 0) {
        $insertService = "INSERT INTO services (name, description, base_price, category) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertService);
        $insertStmt->bind_param("ssds", $service[0], $service[1], $service[2], $service[3]);
        
        if ($insertStmt->execute()) {
            echo "Service '{$service[0]}' added successfully.<br>";
        } else {
            echo "Error adding service '{$service[0]}': " . $insertStmt->error . "<br>";
        }
        $insertStmt->close();
    }
    $checkStmt->close();
}

$conn->close();
echo "<br>Database setup completed!<br>";
echo "<a href='index.html'>Go to Homepage</a>";
?>