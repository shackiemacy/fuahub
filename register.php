<?php
session_start();

// Only allow POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: signup.html?error=invalid_method");
    exit();
}

// Include database connection
include 'db_connection.php';

// Validate and sanitize input data
if (!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['role'])) {
    header("Location: signup.html?error=missing_fields");
    exit();
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';
$role = $_POST['role'];

// Basic validation
if (empty($username) || empty($email) || empty($password)) {
    header("Location: signup.html?error=empty_fields");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: signup.html?error=invalid_email");
    exit();
}

if (strlen($password) < 8) {
    header("Location: signup.html?error=weak_password");
    exit();
}

if ($password !== $confirmPassword) {
    header("Location: signup.html?error=password_mismatch");
    exit();
}

if (!in_array($role, ['client', 'service_provider'])) {
    header("Location: signup.html?error=invalid_role");
    exit();
}

try {
    // Check if email already exists
    $checkEmail = "SELECT id FROM users WHERE email = ?";
    $checkStmt = $conn->prepare($checkEmail);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows > 0) {
        $checkStmt->close();
        header("Location: signup.html?error=email_exists");
        exit();
    }
    $checkStmt->close();
    
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $sql = "INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);
    
    if ($stmt->execute()) {
        // Set user session
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $email;
        
        $stmt->close();
        $conn->close();
        
        // Redirect to success page or account page
        header("Location: account.html?success=registration");
        exit();
    } else {
        throw new Exception("Database error: " . $stmt->error);
    }
    
} catch (Exception $e) {
    error_log("Registration error: " . $e->getMessage());
    header("Location: signup.html?error=database_error");
    exit();
}
?>


