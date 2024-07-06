<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_workshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT appointments.*, mechanics.name AS mechanic_name FROM appointments 
        JOIN mechanics ON appointments.mechanic_id = mechanics.id";
$result = $conn->query($sql);

$appointments = array();
while($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

$conn->close();

echo json_encode($appointments);
?>