<?php
// Database configuration
$servername = "db-service"; // For Docker and Minikube, use the appropriate IP or hostname
$username = "admin";
$password = "root"; // Assuming the password is 'root'
$dbname = "myclinic"; // Change this to your database name if different

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
