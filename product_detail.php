<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Page</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/detailstyle.css">
    <link rel="stylesheet" href="/css/sharedstyle.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <div id="trailer"></div>
    <!-- Navigation bar -->
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
    <!-- Product Detail -->
    <div class="container product_detail">
        <?php
        $servername = "localhost:3306";
        $username = "root";
        $password = "";
        $dbname = "sse3308";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get the product ID from the URL
        $productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($productId > 0) {
            // Fetch product details from the database
            $sql = "SELECT * FROM product_info WHERE id = $productId";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $product = $result->fetch_assoc();

                $detailHtml = "
                <div class=\"card\">
                    <div class=\"imgBx\">
                        <img src=\"" . htmlspecialchars($product['image']) . "\" alt=\"Product Image\">
                    </div>
                    <div class=\"details\">
                        <div class=\"content\">
                            <div class=\"description\">
                                <h2>" . htmlspecialchars($product['name']) . "<br></h2>
                                <p>" . htmlspecialchars($product['description']) . "</p>";

                // Check if ingredients are not empty
                if (!empty($product['ingredients'])) {
                    $detailHtml .= "
                                <table>
                                    <tr><th colspan=\"2\">Nutrition Facts</th></tr>
                                    <tr><td>Ingredients</td><td>" . htmlspecialchars($product['ingredients']) . "</td></tr>
                                    <tr><td>Serving size</td><td>" . htmlspecialchars($product['serving_size']) . "</td></tr>
                                    <tr><td>Calories</td><td>" . htmlspecialchars($product['calories']) . "</td></tr>
                                    <tr><td>Total Fat</td><td>" . htmlspecialchars($product['total_fat_value']) . "g (" . htmlspecialchars($product['total_fat_percent']) . "%)</td></tr>
                                    <tr><td>Cholesterol</td><td>" . htmlspecialchars($product['cholesterol_value']) . "mg (" . htmlspecialchars($product['cholesterol_percent']) . "%)</td></tr>
                                    <tr><td>Sodium</td><td>" . htmlspecialchars($product['sodium_value']) . "mg (" . htmlspecialchars($product['sodium_percent']) . "%)</td></tr>
                                    <tr><td>Total Carbohydrate</td><td>" . htmlspecialchars($product['total_carbohydrate_value']) . "g (" . htmlspecialchars($product['total_carbohydrate_percent']) . "%)</td></tr>
                                    <tr><td>Sugars</td><td>" . htmlspecialchars($product['sugars_value']) . "g</td></tr>
                                    <tr><td>Protein</td><td>" . htmlspecialchars($product['protein_value']) . "g</td></tr>
                                </table>";
                }

                $detailHtml .= "
                                <div class=\"purchase\">
                                    <h3>" . htmlspecialchars($product['price']) . "</h3>
                                    <button id=\"addToCartButton\" onclick = 'showDialog()'>Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";

                echo $detailHtml;
            } else {
                echo "<p>Product not found</p>";
            }
        } else {
            echo "<p>Invalid product ID</p>";
        }

        $conn->close();
        ?>
    </div>
    
    <!-- Contact form & Footer -->
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
    
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
<!--js for popup message add to cart button-->
<script>
        function showDialog() {
            swal({
                text: "The item was successfully added to your cart!",
                buttons: {
                    viewCart: {
                        text: "View Cart",
                        value: "viewCart",
                    },
                    checkout: {
                        text: "Checkout",
                        value: "checkout",
                    },
                },
            }).then((value) => {
                switch (value) {
                    case "viewCart":
                        window.location.href = "cart.html"; // Redirect to cart page
                        break;

                    case "checkout":
                        window.location.href = "checkout.html"; // Redirect to checkout page
                        break;

                    default:
                        // Do nothing if the dialog is closed without a button click
                        break;
                }
            });
        }
    </script> 
    <script src="main.js"></script>
</body>
</html>
