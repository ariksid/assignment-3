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
    <title>Mechanics Available</title>
    <link rel="stylesheet" href="styles.css">
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
        <h1>Mechanics Available</h1>
        <ul id="mechanicsList">
            
        </ul>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('get_mechanics.php')
                .then(response => response.json())
                .then(data => {
                    const mechanicsList = document.getElementById('mechanicsList');
                    mechanicsList.innerHTML = '';
                    data.forEach(mechanic => {
                        const listItem = document.createElement('li');
                        listItem.textContent = mechanic.name;
                        mechanicsList.appendChild(listItem);
                    });
                })
                .catch(error => console.error('Error fetching mechanics:', error));
        });
    </script>
</body>
</html>