<?php
include 'db_config.php';

$sql = "SELECT * FROM services";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>" . $row['name'] . "</h3>";
        echo "<p>" . $row['description'] . "</p>";
        echo "<p>Price: Ksh. " . $row['base_price'] . "</p>";
        echo "</div>";
    }
} else {
    echo "No services available.";
}

$conn->close();
?>
