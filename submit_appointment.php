<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Appointment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('b6.jpg'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
            text-align: center;
        }
        .container {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
        }
        .success-message {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .error-message {
            font-size: 24px;
            margin-bottom: 20px;
            color: red;
        }
        .back-button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "car_workshop";

        
        $conn = new mysqli($servername, $username, $password, $dbname);

        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $client_name = $_POST['client_name'];
            $phone = $_POST['phone'];
            $car_color = $_POST['car_color'];
            $car_license = $_POST['car_license'];
            $car_engine = $_POST['car_engine'];
            $appointment_date = $_POST['appointment_date'];
            $mechanic_id = $_POST['mechanic_id'];

            // Insert data into database
            $sql = "INSERT INTO appointments (client_name, phone, car_color, car_license, car_engine, appointment_date, mechanic_id)
                    VALUES ('$client_name', '$phone', '$car_color', '$car_license', '$car_engine', '$appointment_date', '$mechanic_id')";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='success-message'>Appointment booked successfully!</div>";
            } else {
                echo "<div class='error-message'>Error: " . $sql . "<br>" . $conn->error . "</div>";
            }
        }

        $conn->close();
        ?>
        <a href="book_appointment.php" class="back-button">Back to Booking Page</a>
    </div>
</body>
</html>