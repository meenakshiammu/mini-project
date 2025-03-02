<?php 
// Database connection 
$conn = new mysqli('localhost', 'root', '', 'infiniti-stay-hub-'); 
 
// Check connection 
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get customer checkout details from POST request
    $firstName = @$_POST['firstName']; 
    $lastName = @$_POST['lastName']; 
    $email = @$_POST['email']; 
    $password = @$_POST['password']; 
    $room_number = @$_POST['room_number']; 

    // Validate customer in registration and customer_bookings table
    $sql_check = "SELECT * FROM registration WHERE email = ? AND password = ? AND firstName = ? AND lastName = ?";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param("ssss", $email, $password, $firstName, $lastName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Check if the room is booked by the customer
        $row = $result->fetch_assoc();
        $sql_booking = "SELECT * FROM customer_bookings WHERE room_number = ? AND customer_email = ?";
        $stmt_booking = $conn->prepare($sql_booking);
        $stmt_booking->bind_param("is", $room_number, $email);
        $stmt_booking->execute();
        $booking_result = $stmt_booking->get_result();

        if ($booking_result->num_rows > 0) {
            // Room is booked by the customer, proceed with checkout
            // Delete from customer_bookings
            $delete_booking = "DELETE FROM customer_bookings WHERE room_number = ? AND customer_email = ?";
            $stmt_delete_booking = $conn->prepare($delete_booking);
            $stmt_delete_booking->bind_param("is", $room_number, $email);
            if ($stmt_delete_booking->execute()) {
                // Mark the room as available
                $update_room = "UPDATE room_details SET is_booked = 0 WHERE room_number = ?";
                $stmt_update_room = $conn->prepare($update_room);
                $stmt_update_room->bind_param("i", $room_number);
                if ($stmt_update_room->execute()) {
                    echo "<script>
                            alert('Checkout successful! Room $room_number is now available.');
                            window.location.href = 'roombooking.php';
                          </script>";
                } else {
                    echo "Error updating room status: " . $conn->error;
                }
            } else {
                echo "Error during checkout: " . $conn->error;
            }
        } else {
            echo "Error: Room was not booked by you or has already been checked out.";
        }
    } else {
        echo "Error: Invalid customer details or not registered.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        form {
            max-width: 400px;
            margin: 50px auto;
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
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            width: 100%;
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Checkout</h2>
    <form method="POST" action="">
        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" required>

        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <label for="room_number">Room Number:</label>
        <input type="number" name="room_number" required>

        <button type="submit">Checkout</button>
    </form>
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
