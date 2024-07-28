<?php
// Include the database connection file
include('db_connect.php');
session_start(); // Start the session

// Handle the add food request
if (isset($_POST['add_food'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];

    // Prepare an insert statement
    $stmt = $conn->prepare("INSERT INTO food_items (name, description, price, category, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $name, $description, $price, $category, $image_url);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Food item added successfully.'; // Set the session message
    } else {
        $_SESSION['message'] = 'Error: ' . $stmt->error; // Set the error message
    }

    $stmt->close();
    $conn->close();

    header("Location: food_management.php"); // Redirect to the food management page
    exit();
}
?>
