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

// Fetch room details
$sql = "SELECT * FROM room_details";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Room Details</h2>
    <table border="1">
        <tr>
            <th>Room Number</th>
            <th>Room Type</th>
            <th>Status</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['room_number'] . "</td>";
                echo "<td>" . ($row['is_booked'] ? "Booked" : "Available") . "</td>";
                if ($row['is_booked'] == 0) {
                    echo "<td><a href='customerbookings.php?room_number=" . $row['room_number'] . "'>Book</a></td>";
                } else {
                    echo "<td>Unavailable</td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No rooms available</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
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