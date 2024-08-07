<?php
// Start the session
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

include('configs/db.php');

// Fetch the product details
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id='$product_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Product not found.'); window.location.href = 'view_products.php';</script>";
        exit();
    }
}

// Update product details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Handle image upload
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $sql = "UPDATE products SET name='$name', description='$description', price='$price', stock='$stock', image='$image' WHERE id='$product_id'";
    } else {
        $sql = "UPDATE products SET name='$name', description='$description', price='$price', stock='$stock' WHERE id='$product_id'";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product updated successfully!'); window.location.href = 'view_products.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Product</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required>
            
            <label for="description">Description</label>
            <input type="text" id="description" name="description" value="<?php echo $product['description']; ?>" required>
            
            <label for="price">Price</label>
            <input type="number" id="price" name="price" value="<?php echo $product['price']; ?>" required>
            
            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock" value="<?php echo $product['stock']; ?>" required>
            
            <label for="image">Image</label>
            <input type="file" id="image" name="image">
            
            <button type="submit">Update Product</button>
        </form>
        <a href="view_products.php">Cancel</a>
    </div>
</body>
</html>
