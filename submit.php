<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "eventdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name    = $_POST['name'];
$email   = $_POST['email'];
$guests  = $_POST['guests'];
$message = $_POST['message'];

$sql = "INSERT INTO invitations (name, email, guests, message)
        VALUES ('$name', '$email', '$guests', '$message')";

if ($conn->query($sql) === TRUE) {
    echo "<h2>✅ RSVP Submitted Successfully!</h2>";
    echo "<a href='view.php'>View All Responses</a>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>