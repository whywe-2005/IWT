<?php
header('Content-Type: application/json');
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "event_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit();
}
$name = $conn->real_escape_string($_POST['name']);
$email = $conn->real_escape_string($_POST['email']);
$attending = $conn->real_escape_string($_POST['attending']);
if (empty($name) || empty($email) || ($attending !== 'yes' && $attending !== 'no')) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill all required fields correctly.']);
    exit();
}
$check_sql = "SELECT id FROM rsvp WHERE email = '$email'";
$result = $conn->query($check_sql);
if ($result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'You have already submitted an RSVP.']);
    exit();
}
$sql = "INSERT INTO rsvp (full_name, email, attending) VALUES ('$name', '$email', '$attending')";
if ($conn->query($sql) === TRUE) {
    $response_message = ($attending === 'yes') 
        ? "Thank you, $name! Your attendance is confirmed." 
        : "Understood, $name. We've recorded your status.";
    echo json_encode(['status' => 'success', 'message' => $response_message]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
}
$conn->close();
?>