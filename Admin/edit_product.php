<?php
include('db_connect.php');
include('session_check.php');

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (isset($_POST['update_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    
    if (!empty($_FILES['image']['tmp_name'])) {
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
        $stmt = $conn->prepare("UPDATE menu SET name = ?, description = ?, price = ?, category = ?, stock = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssdsbsi", $name, $description, $price, $category, $stock, $imgContent, $id);
    } else {
        $stmt = $conn->prepare("UPDATE menu SET name = ?, description = ?, price = ?, category = ?, stock = ? WHERE id = ?");
        $stmt->bind_param("ssdsii", $name, $description, $price, $category, $stock, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully!'); window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'admin_dashboard.php';</script>";
    }

    $stmt->close();
}
$conn->close();
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
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        
        <label for="description">Product Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        
        <label for="price">Product Price:</label>
        <input type="number" step="0.01" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>
        
        <label for="stock">Product Stock:</label>
        <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
        
        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image" accept="image/*">
        
        <button type="submit" name="update_product">Update Product</button>
    </form>
</div>
</body>
</html>
