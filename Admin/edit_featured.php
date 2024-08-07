<?php include('../partials/menu.php'); ?>
<?php
include('db_connect.php');
include('session_check.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    
    // Check if a new image is uploaded
    if (!empty($_FILES['image']['tmp_name'])) {
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
        $sql = "UPDATE featured_menu SET name='$name', description='$description', price='$price', category='$category', image='$imgContent' WHERE id='$id'";
    } else {
        $sql = "UPDATE featured_menu SET name='$name', description='$description', price='$price', category='$category' WHERE id='$id'";
    }
    
    // Execute the query and check if it was successful
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product updated successfully!'); window.location.href = 'featured_menu.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'featured_menu.php';</script>";
    }
}

// Check if the id is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM featured_menu WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);
    mysqli_close($conn);
} else {
    header("Location: featured_menu.php");
    exit();
}
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
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>

    <h3>Edit Product</h3>
    <form action="edit_featured.php" method="post" enctype="multipart/form-data" onsubmit="return validateProductForm()">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required>

        <label for="description">Product Description:</label>
        <textarea id="description" name="description" required><?php echo $product['description']; ?></textarea>

        <label for="price">Product Price:</label>
        <input type="number" step="0.01" id="price" name="price" value="<?php echo $product['price']; ?>" required>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" value="<?php echo $product['category']; ?>" required>

        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image" accept="image/*">
        <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="Product Image" width="100">

        <button type="submit">Update Product</button>
    </form>
</body>
</html>
