<?php
// Database connection (PHP code)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "infiniti-stay-hub-";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch feedback data (PHP code)
$sql = "SELECT name, email, rating, comments FROM feedback";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Feedback Page</title>
</head>
<body>
    <h1>User Feedback</h1>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Rating</th>
            <th>Comments</th>
        </tr>
        <?php
        // Display feedback data in HTML (PHP code inside HTML)
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["rating"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["comments"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No feedback available</td></tr>";
        }
        ?>
    </table>
</body>
</html>
<style>
    /* General Page Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 20px;
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Table Styling */
table {
    width: 80%;
    margin: 0 auto;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #f1f1f1;
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    table {
        width: 100%;
    }

    th, td {
        font-size: 14px;
        padding: 10px;
    }
}
</style>
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