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

$sql = "SELECT mechanics.id, mechanics.name, mechanics.max_cars - COUNT(appointments.id) AS available_slots
        FROM mechanics
        LEFT JOIN appointments ON mechanics.id = appointments.mechanic_id
        GROUP BY mechanics.id, mechanics.name, mechanics.max_cars";
$result = $conn->query($sql);

if ($result === FALSE) {
    echo json_encode(["error" => $conn->error]);
    exit;
}

$mechanics = array();
while($row = $result->fetch_assoc()) {
    $mechanics[] = $row;
}

$conn->close();

echo json_encode($mechanics);
?>