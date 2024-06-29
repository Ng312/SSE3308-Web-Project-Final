<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "sse3308";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$user = $_POST['username'];
$email = $_POST['email'];
$message = $_POST['message'];

// Insert message into the database
$sql = "INSERT INTO messages (username, message, email) VALUES ('$user', '$message', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Redirect to a confirmation or message board page
header("Location: message_board.php");
exit();
?>
