<?php include('../partials/menu.php'); ?>

<?php
// Include the database connection file
include('db_connect.php');
include('session_check.php');


// Handle deletion of food item
if (isset($_GET['delete'])) {
    $food_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM food_items WHERE id = ?");
    $stmt->bind_param("i", $food_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Delete Successfully'; // Set the session message
        header("Location: food_management.php"); // Redirect to the same page
        exit();
    } else {
        $_SESSION['message'] = 'Error: ' . $stmt->error; // Set the error message
        header("Location: food_management.php"); // Redirect to the same page
        exit();
    }

    $stmt->close();
}

// Fetch all food items
$result = $conn->query("SELECT * FROM food_items");

// Handle display of messages
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']); // Clear the message after displaying it

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Management</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background-color: #f4f4f4; }
        img { width: 100px; height: auto; }
        .actions a { margin-right: 10px; }
        .message { padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>Food Management</h1>
    
    <!-- Display message -->
    <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'Error') === false ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Add New Food Item Form -->
    <form action="add_food.php" method="POST">
        <h2>Add New Food Item</h2>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required>
        <label for="category">Category:</label>
        <input type="text" id="category" name="category">
        <label for="image_url">Image URL:</label>
        <input type="text" id="image_url" name="image_url">
        <button type="submit" name="add_food">Add Food Item</button>
    </form>

    <!-- Display Current Food Items -->
    <h2>Current Food Items</h2>
    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Food Image"></td>
                        <td class="actions">
                            <a href="update_food.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a href="food_management.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No food items found.</p>
    <?php endif; ?>

    <?php
    // Close the connection
    $conn->close();
    ?>


<?php include('../partials/footer.php'); ?>
