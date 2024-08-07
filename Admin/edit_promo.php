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
    $date = $_POST['date'];
    
    // Check if a new image is uploaded
    if (!empty($_FILES['image']['tmp_name'])) {
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
        $sql = "UPDATE promotions SET name='$name', description='$description', price='$price', date='$date', image='$imgContent' WHERE id='$id'";
    } else {
        $sql = "UPDATE promotions SET name='$name', description='$description', price='$price', date='$date' WHERE id='$id'";
    }
    
    // Execute the query and check if it was successful
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Promotion updated successfully!'); window.location.href = 'promotions.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'promotions.php';</script>";
    }
}

// Check if the id is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM promotions WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $promotion = mysqli_fetch_assoc($result);
    mysqli_close($conn);
} else {
    header("Location: promotions.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Promotion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>

    <h3>Edit Promotion</h3>
    <form action="edit_promo.php" method="post" enctype="multipart/form-data" onsubmit="return validateProductForm()">
        <input type="hidden" name="id" value="<?php echo $promotion['id']; ?>">
        <label for="name">Promotion Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $promotion['name']; ?>" required>

        <label for="description">Promotion Description:</label>
        <textarea id="description" name="description" required><?php echo $promotion['description']; ?></textarea>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" value="<?php echo $promotion['price']; ?>" required>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo $promotion['date']; ?>" required>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*">
        <img src="data:image/jpeg;base64,<?php echo base64_encode($promotion['image']); ?>" alt="Promotion Image" width="100">

        <button type="submit">Update Promotion</button>
    </form>
</body>
</html>
