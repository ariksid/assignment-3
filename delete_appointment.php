<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_workshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$appointment_id = $_POST['appointment_id'];

$sql = "DELETE FROM appointments WHERE id = $appointment_id";

if ($conn->query($sql) === TRUE) {
    echo "Appointment deleted successfully!";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>