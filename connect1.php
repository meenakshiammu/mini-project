<?php
	$name = $_POST['name'];
	$email = $_POST['email'];
	$rating = $_POST['rating'];
	$comments = $_POST['comments'];

	// Database connection
	$conn = new mysqli('localhost','root','','infiniti-stay-hub-');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$stmt = $conn->prepare("insert into feedback(name,  email, rating, comments) values(?, ?, ?, ?)");
		$stmt->bind_param("ssis", $name,  $email, $rating, $comments);
		$execval = $stmt->execute();
		echo $execval;
		echo "feedback given successfully...";
		$stmt->close();
		$conn->close();
	}
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
