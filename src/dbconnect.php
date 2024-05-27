<?php
// Database configuration
$servername = "dani-db-service"; // Using the Kubernetes service name for the database
$username = "admin"; // As defined in the StatefulSet
$password = "root"; // As defined in the StatefulSet, consider using environment variables for production
$dbname = "myclinic"; // As defined in the StatefulSet

// Create connection using mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}

// Close the connection
$conn->close();
?>
