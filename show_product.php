<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "sse3308";

// Create connection using PDO for prepared statements
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch product data using prepared statement
    $stmt = $conn->prepare("SELECT id, name, price, image FROM product_info");
    $stmt->execute();

    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$conn = null; // Close the connection

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Page</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/productstyle.css">
    <link rel="stylesheet" href="/css/sharedstyle.css">
</head>
<body>
    <div id="trailer"></div>
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
                        <a class="nav-link dropdown-toggle" href="show_product.php" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">Products</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="show_product.php">Peanut Butter</a>
                            <a class="dropdown-item" href="show_product.php">Almond Butter</a>
                            <a class="dropdown-item" href="show_product.php">Pistachio Butter</a>
                            <a class="dropdown-item" href="show_product.php">Cashew Butter</a>
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

    <div class="quick-nav">
        <a href="index.html">Home</a>
        <p>&gt</p>
        <p>Products</p>
    </div>

    <h1>All Products</h1>
    <div class="row products">
        <?php foreach ($productData as $product): ?>
            <div class="wrapper">
                <div class="container" data-id="<?php echo htmlspecialchars($product['id']); ?>">
                    <div class="top" style="background: url('<?php echo htmlspecialchars($product['image']); ?>') no-repeat center; background-size: 60%;"></div>
                    <div class="bottom">
                        <div class="left">
                            <div class="details">
                                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                                <p><?php echo htmlspecialchars($product['price']); ?></p>
                            </div>
                            <div class="buy"><img src="/img/cart.png" alt="Cart Icon"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Add New Product Button -->
    <div class="button-container">
        <a href="add_product.php" class="btn btn-warning">Manage Products</a>
    </div>

    <!--Contact form & Footer-->
    <footer class="bg-body-tertiary text-lg-start" style="background-color: #f1e2c5">
        <div class="row">
            <div class="col-8">
                <form class="contact-form" method="post" action="post_message.php" id="contact">
                    <div class="form-title">
                        <h5 id="contact-us">CONTACT</h5>
                        <h6>US</h6>
                    </div>
                    <div class="form-body-item">
                        <div class="form-group">
                            <input type="text" id="name" class="input" placeholder="NAME" name="username" required>
                            <input type="email" id="email" class="input" placeholder="EMAIL" name="email" required>
                            <input type="text" id="message" class="input" placeholder="MESSAGE" name="message" required>
                            <button type="submit" form="contact" value="Submit">Send</button>
                        </div>
                    </div>
                </form>
                <div class="copyright text-center">
                    © 2024 Copyright:
                    <a class="text-body" href="index.html">Spreads.com</a>
                </div>
            </div>
            <div class="col-4">
                <img src="/img/form-image.png" alt="spreads image">
            </div>
        </div>
    </footer>
    <script src="main.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        let containers = document.querySelectorAll(".container");
        containers.forEach(container => {
            container.addEventListener("click", function () {
                let productId = this.getAttribute("data-id");
                window.location.href = "/product_detail.php?id=" + encodeURIComponent(productId);
            });
        });
    });
    </script>
</body>
</html>
