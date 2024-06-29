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

$message = []; 

function getNextProductId($conn) {
    $query = "SELECT MAX(id) as max_id FROM product_info";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['max_id'] + 1; 
    } else {
        return 1; // If no records exist, start from 1
    }
}

if (isset($_POST['save_product'])) {
    $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];
    $p_description = $_POST['p_description'];
    $p_ingredients = $_POST['p_ingredients'];
    $p_serving_size = $_POST['p_serving_size'];
    $p_calories = $_POST['p_calories'];
    $p_total_fat_value = $_POST['p_total_fat_value'];
    $p_total_fat_percent = $_POST['p_total_fat_percent'];
    $p_cholesterol_value = $_POST['p_cholesterol_value'];
    $p_cholesterol_percent = $_POST['p_cholesterol_percent'];
    $p_sodium_value = $_POST['p_sodium_value'];
    $p_sodium_percent = $_POST['p_sodium_percent'];
    $p_total_carbohydrate_value = $_POST['p_total_carbohydrate_value'];
    $p_total_carbohydrate_percent = $_POST['p_total_carbohydrate_percent'];
    $p_dietary_fiber_value = $_POST['p_dietary_fiber_value'];
    $p_dietary_fiber_percent = $_POST['p_dietary_fiber_percent'];
    $p_sugars_value = $_POST['p_sugars_value'];
    $p_sugars_percent = $_POST['p_sugars_percent'];
    $p_protein_value = $_POST['p_protein_value'];
    $p_protein_percent = $_POST['p_protein_percent'];

    $p_image_folder = '';
    if (isset($_FILES['p_image']) && $_FILES['p_image']['error'] === 0) {
        $p_image = $_FILES['p_image']['name'];
        $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
        $upload_directory = 'uploaded_img/';
        $p_image_folder = $upload_directory . $p_image;
        if (!file_exists($upload_directory)) {
            mkdir($upload_directory, 0777, true); // Create the directory if it doesn't exist
        }
        if (move_uploaded_file($p_image_tmp_name, $p_image_folder)) {
            $message[] = 'File uploaded successfully.';
        } else {
            $message[] = 'Failed to move file to destination directory.';
        }
    }

    if (isset($_POST['product_id'])) {
        // Update product
        $product_id = $_POST['product_id'];

        if ($p_image_folder) {
            $update_query = "UPDATE product_info SET name=?, price=?, image=?, description=?, ingredients=?, serving_size=?, calories=?, total_fat_value=?, total_fat_percent=?, cholesterol_value=?, cholesterol_percent=?, sodium_value=?, sodium_percent=?, total_carbohydrate_value=?, total_carbohydrate_percent=?, dietary_fiber_value=?, dietary_fiber_percent=?, sugars_value=?, sugars_percent=?, protein_value=?, protein_percent=? WHERE id=?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("sssssdddddddddddddddsi", $p_name, $p_price, $p_image_folder, $p_description, $p_ingredients, $p_serving_size, $p_calories, $p_total_fat_value, $p_total_fat_percent, $p_cholesterol_value, $p_cholesterol_percent, $p_sodium_value, $p_sodium_percent, $p_total_carbohydrate_value, $p_total_carbohydrate_percent, $p_dietary_fiber_value, $p_dietary_fiber_percent, $p_sugars_value, $p_sugars_percent, $p_protein_value, $p_protein_percent, $product_id);
        } else {
            $update_query = "UPDATE product_info SET name=?, price=?, description=?, ingredients=?, serving_size=?, calories=?, total_fat_value=?, total_fat_percent=?, cholesterol_value=?, cholesterol_percent=?, sodium_value=?, sodium_percent=?, total_carbohydrate_value=?, total_carbohydrate_percent=?, dietary_fiber_value=?, dietary_fiber_percent=?, sugars_value=?, sugars_percent=?, protein_value=?, protein_percent=? WHERE id=?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("sssddddddddddddddsi", $p_name, $p_price, $p_description, $p_ingredients, $p_serving_size, $p_calories, $p_total_fat_value, $p_total_fat_percent, $p_cholesterol_value, $p_cholesterol_percent, $p_sodium_value, $p_sodium_percent, $p_total_carbohydrate_value, $p_total_carbohydrate_percent, $p_dietary_fiber_value, $p_dietary_fiber_percent, $p_sugars_value, $p_sugars_percent, $p_protein_value, $p_protein_percent, $product_id);
        }

        if ($stmt->execute()) {
            $message[] = 'Product updated successfully';
        } else {
            $message[] = 'Could not update the product';
        }
    } else {
        // Insert new product
        $insert_query = "INSERT INTO product_info (id, name, price, image, description, ingredients, serving_size, calories, total_fat_value, total_fat_percent, cholesterol_value, cholesterol_percent, sodium_value, sodium_percent, total_carbohydrate_value, total_carbohydrate_percent, dietary_fiber_value, dietary_fiber_percent, sugars_value, sugars_percent, protein_value, protein_percent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $next_id = getNextProductId($conn); 
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("dsssssdddddddddddddddd", $next_id, $p_name, $p_price, $p_image_folder, $p_description, $p_ingredients, $p_serving_size, $p_calories, $p_total_fat_value, $p_total_fat_percent, $p_cholesterol_value, $p_cholesterol_percent, $p_sodium_value, $p_sodium_percent, $p_total_carbohydrate_value, $p_total_carbohydrate_percent, $p_dietary_fiber_value, $p_dietary_fiber_percent, $p_sugars_value, $p_sugars_percent, $p_protein_value, $p_protein_percent);
        if ($stmt->execute()) {
            $message[] = 'Product added successfully';
        } else {
            $message[] = 'Could not add the product';
        }
    }
    $stmt->close();
}

// Delete product 
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_query = "DELETE FROM product_info WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        header('location:add_product.php');
        $message[] = 'Product has been deleted';
    } else {
        header('location:add_product.php');
        $message[] = 'Product could not be deleted';
    }
    $stmt->close();
}

$product_to_edit = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_query = "SELECT * FROM product_info WHERE id = ?";
    $stmt = $conn->prepare($edit_query);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $product_to_edit = $result->fetch_assoc();
    }
    $stmt->close();
}

// Display messages
if (isset($message)) {
    foreach ($message as $msg) {
        echo '<div class="message"><span>' . $msg . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = none;"></i> </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Product Management</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
   integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

   <link rel="stylesheet" href="/css/sharedstyle.css">
   <link rel="stylesheet" href="/css/add_productstyle.css">

</head>
<body>
<div class="quick-nav">
    <a href="show_product.php">Product Page</a>
    <p>&gt</p>
    <p>Product Management</p>
</div>
<div class="container">
   <section>
      <form method="post" class="add-product-form" enctype="multipart/form-data">
         <h3 class="text-center mb-4"><?= isset($product_to_edit) ? 'Update Product' : 'Add New Product' ?></h3>
         <?php if(isset($product_to_edit)): ?>
            <input type="hidden" name="product_id" value="<?= $product_to_edit['id'] ?>">
         <?php endif; ?>
         <div class="form-group">
            Product Name <input type="text" name="p_name" placeholder="Product name" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['name'] : '' ?>">
         </div>
         <div class="form-group">
            Product Price <input type="text" name="p_price" min="0" placeholder="Product price" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['price'] : '' ?>">
         </div>
         <div class="form-group">
            Product Image <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="form-control-file">
            <?php if(isset($product_to_edit) && $product_to_edit['image']): ?>
               <img src="<?= $product_to_edit['image'] ?>" height="100" alt="Product Image">
            <?php endif; ?>
         </div>
         <div class="form-group">
            Product Description <textarea name="p_description" placeholder="Product description" class="form-control" required><?= isset($product_to_edit) ? $product_to_edit['description'] : '' ?></textarea>
         </div>
         <div class="form-group">
            Product Ingredients <textarea name="p_ingredients" placeholder="Product ingredients" class="form-control" required><?= isset($product_to_edit) ? $product_to_edit['ingredients'] : '' ?></textarea>
         </div>
         <div class="form-group">
            Serving Size <input type="text" name="p_serving_size" placeholder="Serving size" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['serving_size'] : '' ?>">
         </div>
         <div class="form-group">
            Calories <input type="number" name="p_calories" min="0" placeholder="Calories" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['calories'] : '' ?>">
         </div>
         <div class="row">
            <div class="form-group col-md-6">
               Total Fat Value <input type="number" name="p_total_fat_value" min="0" placeholder="Total fat value" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['total_fat_value'] : '' ?>">
            </div>
            <div class="form-group col-md-6">
               Fat Percentage <input type="number" name="p_total_fat_percent" min="0" placeholder="Fat percentage" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['total_fat_percent'] : '' ?>">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-md-6">
               Cholesterol Value <input type="number" name="p_cholesterol_value" min="0" placeholder="Cholesterol value" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['cholesterol_value'] : '' ?>">
            </div>
            <div class="form-group col-md-6">
               Cholesterol Percentage <input type="number" name="p_cholesterol_percent" min="0" placeholder="Cholesterol percentage" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['cholesterol_percent'] : '' ?>">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-md-6">
               Sodium Value <input type="number" name="p_sodium_value" min="0" placeholder="Sodium value" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['sodium_value'] : '' ?>">
            </div>
            <div class="form-group col-md-6">
               Sodium Percentage <input type="number" name="p_sodium_percent" min="0" placeholder="Sodium percentage" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['sodium_percent'] : '' ?>">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-md-6">
               Total Carbohydrate Value <input type="number" name="p_total_carbohydrate_value" min="0" placeholder="Total carbohydrate value" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['total_carbohydrate_value'] : '' ?>">
            </div>
            <div class="form-group col-md-6">
               Carbohydrate Percentage <input type="number" name="p_total_carbohydrate_percent" min="0" placeholder="Total carbohydrate percentage" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['total_carbohydrate_percent'] : '' ?>">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-md-6">
               Dietary Fiber Value <input type="number" name="p_dietary_fiber_value" min="0" placeholder="Dietary fiber value" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['dietary_fiber_value'] : '' ?>">
            </div>
            <div class="form-group col-md-6">
               Dietary Fiber Percentage <input type="number" name="p_dietary_fiber_percent" min="0" placeholder="Dietary fiber percentage" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['dietary_fiber_percent'] : '' ?>">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-md-6">
               Sugar Value <input type="number" name="p_sugars_value" min="0" placeholder="Sugar value" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['sugars_value'] : '' ?>">
            </div>
            <div class="form-group col-md-6">
               Sugar Percentage <input type="number" name="p_sugars_percent" min="0" placeholder="Sugar percentage" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['sugars_percent'] : '' ?>">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-md-6">
               Protein Value <input type="number" name="p_protein_value" min="0" placeholder="Protein value" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['protein_value'] : '' ?>">
            </div>
            <div class="form-group col-md-6">
               Protein Percentage <input type="number" name="p_protein_percent" min="0" placeholder="Protein percentage" class="form-control" required value="<?= isset($product_to_edit) ? $product_to_edit['protein_percent'] : '' ?>">
            </div>
         </div>
         <div class="form-group">
            <input type="submit" name="save_product" value="<?= isset($product_to_edit) ? 'Update Product' : 'Add Product' ?>" class="btn btn-warning w-100 mt-3">
         </div>
      </form>
   </section>

   <section class="display-product-table mt-5">
      <table class="table table-bordered table-striped">
         <thead class="thead-dark">
            <tr>
               <th>Product Id</th>
               <th>Product Image</th>
               <th>Product Name</th>
               <th>Product Price</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM product_info");
            if(mysqli_num_rows($select_products) > 0){
               while($row = mysqli_fetch_assoc($select_products)){
            ?>
            <tr>
               <td><?php echo $row['id']; ?></td>
               <td><img src="<?php echo $row['image']; ?>" height="100" alt="Product Image"></td>
               <td><?php echo $row['name']; ?></td>
               <td><?php echo $row['price']; ?></td>
               <td>
                  <a href="add_product.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this?');">Delete</a>
                  <!-- Update link-->
                  <a href="add_product.php?edit=<?php echo $row['id']; ?>" class="btn btn-primary">Update</a>
               </td>
            </tr>
            <?php
               }
            } else {
               echo "<tr><td colspan='5' class='text-center'>No product added</td></tr>";
            }
            ?>
         </tbody>
      </table>
   </section>

</div>
<script src="main.js"></script>
</body>
</html>
