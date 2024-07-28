<?php
// Include the database connection file
include('db_connect.php');
session_start(); // Start the session

// Handle the update request
if (isset($_POST['update_food'])) {
    $food_id = intval($_POST['id']);
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];

    // Prepare an update statement
    $stmt = $conn->prepare("UPDATE food_items SET name = ?, description = ?, price = ?, category = ?, image_url = ? WHERE id = ?");
    $stmt->bind_param("ssdssi", $name, $description, $price, $category, $image_url, $food_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Update Successfully'; // Set the session message
        header("Location: food_management.php"); // Redirect to the food management page
        exit();
    } else {
        $_SESSION['message'] = 'Error: ' . $stmt->error; // Set the error message
        header("Location: food_management.php"); // Redirect to the food management page
        exit();
    }

    $stmt->close();
}

// Fetch the current data for the food item to be updated
if (isset($_GET['id'])) {
    $food_id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM food_items WHERE id = ?");
    $stmt->bind_param("i", $food_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $food_item = $result->fetch_assoc();
    $stmt->close();
} else {
    die('Food item ID is required.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Food Item</title>
</head>
<body>
    <h1>Edit Food Item</h1>

    <!-- Display message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="message <?php echo strpos($_SESSION['message'], 'Error') === false ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($_SESSION['message']); ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <!-- Edit Food Item Form -->
    <form action="update_food.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($food_item['id']); ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($food_item['name']); ?>" required>
        <label for="description">Description:</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($food_item['description']); ?></textarea>
        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" value="<?php echo htmlspecialchars($food_item['price']); ?>" required>
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($food_item['category']); ?>">
        <label for="image_url">Image URL:</label>
        <input type="text" id="image_url" name="image_url" value="<?php echo htmlspecialchars($food_item['image_url']); ?>">
        <button type="submit" name="update_food">Update Food Item</button>
    </form>
</body>
</html>
