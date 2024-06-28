<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spreads Home Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/homestyle.css">
    <link rel="stylesheet" href="/css/sharedstyle.css">
</head>
<body>
    <!--Navigation bar-->
    <div class="container-fluid header-container">
        <nav class="navbar navbar-expand-md navbar-light">
            <div class="brand">
                <h1>Spreads</h1>
                <img class="icon" src="/img/logo.png" alt="jar icon">
            </div>   
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main-navigation">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="show_product.php" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Products
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="show_product.php">Peanut Butter</a>
                            <a class="dropdown-item" href="show_product.php">Almond Butter</a>
                            <a class="dropdown-item" href="show_product.php">Pistachio Butter</a>
                            <a class="dropdown-item" href="show_product.phpl">Cashew Butter</a>
                            <a class="dropdown-item" href="show_product.php">Gift Set</a>
                        </div>
                    </li>                    
                    <li class="nav-item"><a class="nav-link" href="faq.html">FAQs</a></li>    
                    <li class="nav-item"><a class="nav-link" href="#contact-us">Contact Us</a></li>                   
                    <li class="nav-item"><a class="cart" href="cart.html"><img src="/img/cart.png" class="avatar"></a></li> 
                    <li class="nav-item"><a class="user" href="login.html"><img src="/img/user.png" class="avatar"></a></li>   
                </ul>
            </div>
        </nav>
    </div>

    <div class="container">
        <h1 class="my-4">Message Board</h1>
        <div class="messages">
            <?php
            
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
           
            
            $servername = "localhost:3307";
            $username = "root";
            $password = "";
            $dbname = "sse3308";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch messages from the database
            $sql = "SELECT username, message, email, id, timestamp FROM messages ORDER BY timestamp DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<div class='message'>";
                    echo "<h5>" . $row["username"] . "---#" . $row["id"] ."</h5>";
                    echo "<p>" . $row["message"] . "</p>";
                    echo "<small>" . $row["timestamp"] . "</small>";
                    echo "</div><hr>";
                }
            } else {
                echo "No messages found.";
            }

            $conn->close();
            ?>
        </div>
        <div class="new-message-form">
        <h2>Post a new message</h2>
        <form id="messageForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post Message</button>
        </form>
    </div>
    </div>

    <script src="main.js"></script>
    <script>
    document.getElementById('messageForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting the traditional way
        
        var formData = new FormData(this);

        fetch('post_message.php', {
            method: 'POST',
            body: formData
        })

        location.reload();      
    });
</script>


</body>
</html>
