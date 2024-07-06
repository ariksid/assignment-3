<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Appointments</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="mechanics.php">Mechanics Available</a>
        <a href="book_appointment.php">Book Appointment</a>
        <a href="admin.php">Admin</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
        <h1>Manage Appointments</h1>
        <table id="appointmentsTable">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Phone</th>
                    <th>Car Color</th>
                    <th>Car License</th>
                    <th>Car Engine</th>
                    <th>Appointment Date</th>
                    <th>Mechanic</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>

   
    <div id="editModal">
        <form id="editForm">
            <input type="hidden" id="editAppointmentId" name="appointment_id">
            <label for="editDate">Appointment Date:</label>
            <input type="date" id="editDate" name="appointment_date" required>
            
            <label for="editMechanic">Select Mechanic:</label>
            <select id="editMechanic" name="mechanic_id" required>
                <!-- Options will be populated dynamically -->
            </select>
            
            <button type="submit">Save Changes</button>
        </form>
        <button onclick="closeEditModal()">Cancel</button>
    </div>

    <script>
        function fetchAppointments() {
            fetch('get_appointments.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const tbody = document.querySelector('#appointmentsTable tbody');
                    tbody.innerHTML = '';
                    if (data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="8">No appointments found.</td></tr>';
                        return;
                    }
                    data.forEach(appointment => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${appointment.client_name}</td>
                            <td>${appointment.phone}</td>
                            <td>${appointment.car_color}</td>
                            <td>${appointment.car_license}</td>
                            <td>${appointment.car_engine}</td>
                            <td>${appointment.appointment_date}</td>
                            <td>${appointment.mechanic_name}</td>
                            <td>
                                <button onclick="editAppointment(${appointment.id}, '${appointment.appointment_date}', ${appointment.mechanic_id})">Edit</button>
                                <button onclick="deleteAppointment(${appointment.id})">Delete</button>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error fetching appointments:', error);
                });
        }

        function deleteAppointment(id) {
            if (confirm('Are you sure you want to delete this appointment?')) {
                fetch('delete_appointment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({ 'appointment_id': id })
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    fetchAppointments();
                })
                .catch(error => console.error('Error deleting appointment:', error));
            }
        }

        function editAppointment(id, date, mechanicId) {
            document.getElementById('editAppointmentId').value = id;
            document.getElementById('editDate').value = date;
            fetchMechanics(mechanicId);
            document.getElementById('editModal').style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('update_appointment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                closeEditModal();
                fetchAppointments();
            })
            .catch(error => console.error('Error updating appointment:', error));
        });

        function fetchMechanics(selectedMechanicId) {
            fetch('get_mechanics.php')
                .then(response => response.json())
                .then(mechanics => {
                    const mechanicSelect = document.getElementById('editMechanic');
                    mechanicSelect.innerHTML = '';
                    mechanics.forEach(mechanic => {
                        const option = document.createElement('option');
                        option.value = mechanic.id;
                        option.textContent = mechanic.name;
                        if (mechanic.id == selectedMechanicId) {
                            option.selected = true;
                        }
                        mechanicSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching mechanics:', error));
        }

        document.addEventListener('DOMContentLoaded', fetchAppointments);
    </script>
</body>
</html>
