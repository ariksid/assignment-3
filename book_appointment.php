<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="mechanics.php">Mechanics Available</a>
        <a href="book_appointment.php">Book Appointment</a>
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="admin.php">Admin</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
        <h1>Book Appointment</h1>
        <form id="appointmentForm" method="POST" action="submit_appointment.php">
            <label for="client_name">Client Name:</label>
            <input type="text" id="client_name" name="client_name" required>
            
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>
            
            <label for="car_color">Car Color:</label>
            <input type="text" id="car_color" name="car_color" required>
            
            <label for="car_license">Car License:</label>
            <input type="text" id="car_license" name="car_license" required>
            
            <label for="car_engine">Car Engine:</label>
            <input type="text" id="car_engine" name="car_engine" required>
            
            <label for="appointment_date">Appointment Date:</label>
            <input type="date" id="appointment_date" name="appointment_date" required>
            
            <label for="mechanic_id">Select Mechanic:</label>
            <select id="mechanic_id" name="mechanic_id" required>
                
            </select>
            
            <button type="submit">Book Appointment</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('get_mechanics.php')
                .then(response => response.json())
                .then(data => {
                    const mechanicSelect = document.getElementById('mechanic_id');
                    mechanicSelect.innerHTML = '';
                    data.forEach(mechanic => {
                        const option = document.createElement('option');
                        option.value = mechanic.id;
                        option.textContent = mechanic.name;
                        mechanicSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching mechanics:', error));
        });
    </script>
</body>
</html>