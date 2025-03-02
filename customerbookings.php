<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "infiniti-stay-hub-";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get room number from the URL
if (isset($_GET['room_number'])) {
    $room_number = intval($_GET['room_number']); // Sanitize room number
} else {
    die("Room number not specified.");
}

// Check if the room is already booked
$room_query = "SELECT is_booked FROM room_details WHERE room_number = $room_number";
$room_result = $conn->query($room_query);

if ($room_result->num_rows > 0) {
    $room_data = $room_result->fetch_assoc();
    if ($room_data['is_booked'] == 1) {
        die("This room is already booked.");
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $customer_name = $conn->real_escape_string($_POST['customer_name']);
    $customer_email = $conn->real_escape_string($_POST['customer_email']);
    $customer_phone = $conn->real_escape_string($_POST['customer_phone']);

    // Check if the user is registered
    $user_check_query = "SELECT * FROM registration WHERE email = '$customer_email'";
    $user_check_result = $conn->query($user_check_query);

    if ($user_check_result->num_rows > 0) {
        // User is registered, proceed with booking
        $sql = "INSERT INTO customer_bookings (room_number, customer_name, customer_email, customer_phone)
                VALUES ('$room_number', '$customer_name', '$customer_email', '$customer_phone')";

        if ($conn->query($sql) === TRUE) {
            // Update the room_details table to mark the room as booked
            $update_sql = "UPDATE room_details SET is_booked = 1 WHERE room_number = $room_number";
            $conn->query($update_sql);

            echo "<script>
                    alert('Room booked successfully!');
                    window.location.href = 'roombooking.php';
                  </script>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        // User is not registered
        echo "<script>
                alert('You are not registered. Please register to book a room.');
              </script>";
        echo "<a href='BOOK NOW.html'><button>Go to Registration Page</button></a>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        
        h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        /* Form Container */
        form {
            max-width: 400px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            width: 100%;
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Link Button */
        a button {
            display: block;
            margin: 20px auto;
            background-color: #28a745;
            color: #fff;
        }
        a button:hover {
            background-color: #218838;
        }

        /* Footer Styles */
        footer {
            text-align: center;
            margin-top: 20px;
            color: #777;
        }
    </style>
</head>
<body>
    <h2>Book Room <?php echo htmlspecialchars($room_number); ?></h2>
    <form method="POST" action="">
        <label for="customer_name">Name:</label>
        <input type="text" name="customer_name" required>

        <label for="customer_email">Email:</label>
        <input type="email" name="customer_email" required>

        <label for="customer_phone">Phone Number:</label>
        <input type="text" name="customer_phone" required>

        <button type="submit">Book Room</button>
    </form>
    <footer>
        <p>&copy; 2024 Hotel Management System</p>
    </footer>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success</title>
</head>
<body>
    <button onclick="window.location.href='index.html';">Go to Home</button>
</body>
</html>