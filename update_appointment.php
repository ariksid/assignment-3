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
$new_date = $_POST['appointment_date'];
$new_mechanic = $_POST['mechanic_id'];

$sql = "UPDATE appointments SET appointment_date='$new_date', mechanic_id=$new_mechanic WHERE id=$appointment_id";

if ($conn->query($sql) === TRUE) {
    echo "Appointment updated successfully!";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>