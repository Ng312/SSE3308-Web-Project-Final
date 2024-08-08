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

$sql = "SELECT * FROM status_updates ORDER BY timestamp DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='status-update'>";
        echo "<p><strong>" . $row["username"] . "</strong> at " . $row["timestamp"] . "</p>";
        echo "<p>" . $row["status"] . "</p>";
        echo "</div>";
    }
} else {
    echo "No status updates yet.";
}

$conn->close();
?>
