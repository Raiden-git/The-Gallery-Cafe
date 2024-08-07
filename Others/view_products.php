<?php
// Start the session
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['username']) /*||  $_SESSION['role'] !== 'admin' */) {
    header("Location: index.html");
    exit();
}

include('db_connect.php');

// Query to select products
$sql = "SELECT id, name, description, price, category, stock, image FROM menu";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function searchProducts() {
            var input = document.getElementById('searchInput');
            var filter = input.value.toLowerCase();
            var table = document.getElementById('productsTable');
            var tr = table.getElementsByTagName('tr');

            for (var i = 1; i < tr.length; i++) {
                tr[i].style.display = 'none';
                var td = tr[i].getElementsByTagName('td');
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        if (td[j].innerHTML.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = '';
                            break;
                        }
                    }
                }
            }
        }
    </script>
</head>
<body>
    <div class="view-products-container">
        <h2>Available Products</h2>
        <input type="text" id="searchInput" onkeyup="searchProducts()" placeholder="Search for products..">
        <table id="productsTable">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php
            // Check if there are any products in the result
            if (mysqli_num_rows($result) > 0) {
                // Fetch and display each product
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['category'] . "</td>";
                    echo "<td>" . $row['stock'] . "</td>";
                    echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Product Image"/></td>';
                    echo '<td>';
                    echo '<a href="edit_product.php?id=' . $row['id'] . '">Edit</a> | ';
                    echo '<a href="delete_product.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>';
                    echo '</td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No products found</td></tr>";
            }
            // Close the database connection
            mysqli_close($conn);
            ?>
        </table>
        <a href="admin_dashboard.php">Back to Admin Dashboard</a>
    </div>
</body>
</html>
