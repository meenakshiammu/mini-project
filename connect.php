<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'infiniti-stay-hub-');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
    $firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$gender = $_POST['gender'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$number = $_POST['number'];

// Check if email or number already exists
$sql_check = "SELECT * FROM registration WHERE email = ? OR number = ?";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("ss", $email, $number);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Duplicate found
    echo "Error: Email or Number already exists!";
} else {
    // Insert into the database
    $stmt = $conn->prepare("insert into registration(firstName, lastName, gender, email, password, number) values(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $firstName, $lastName, $gender, $email, $password, $number);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

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
