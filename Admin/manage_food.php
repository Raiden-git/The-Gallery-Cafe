<?php include('../partials/menu.php'); ?>

<?php
include('session_check.php');

// The rest of your page code goes here
?>

<?php
// Include the database connection file
include('db_connect.php');

// Fetch all food items
$result = $conn->query("SELECT * FROM food_items");

if ($result) {
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<thead><tr><th>Name</th><th>Description</th><th>Price</th><th>Category</th><th>Image</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['description']) . '</td>';
            echo '<td>' . htmlspecialchars($row['price']) . '</td>';
            echo '<td>' . htmlspecialchars($row['category']) . '</td>';
            echo '<td><img src="' . htmlspecialchars($row['image_url']) . '" alt="Image" style="width:100px;height:auto;"></td>';
            echo '<td>
                    <a href="update_food.php?id=' . $row['id'] . '">Edit</a> |
                    <a href="delete_food.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure?\')">Delete</a>
                  </td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No food items found.</p>';
    }
} else {
    echo '<p>Error executing query: ' . $conn->error . '</p>';
}

// Close the connection
$conn->close();
?>
