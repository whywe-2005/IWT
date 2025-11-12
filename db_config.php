<?php
// --- DOCKER CONNECTION CONFIGURATION ---

// CRITICAL FIX: The host must be the service name 'db' from docker-compose.yml
$servername = "db"; 
$username = "root";      
// CRITICAL FIX: The password must match the MYSQL_ROOT_PASSWORD in docker-compose.yml
$password = "rootpassword";  
$dbname = "event_db"; // Must match MYSQL_DATABASE in docker-compose.yml    

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // If connection fails, display a detailed error and terminate the script
    die("Connection failed: " . $conn->connect_error . 
        ". Please ensure the 'db' container is running and healthy.");
}
// Set character set to avoid issues with data insertion/retrieval
$conn->set_charset("utf8mb4");
?>
