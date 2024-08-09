<?php include('../partials/menu.php'); ?>

<?php
// Start the session
/* session_start(); */

// Check if the user is logged in as admin
/* if (!isset($_SESSION['username']) ||  $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
} */

include('db_connect.php');
include('session_check.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];

    // Retrieve and process the image file
    $image = $_FILES['image']['tmp_name'];
    $imgContent = addslashes(file_get_contents($image));

    // Insert new product into the database
    $sql = "INSERT INTO beverages (name, description, price, stock, image) VALUES ('$name', '$description', '$price', '$stock', '$imgContent')";

    // Execute the query and check if it was successful
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product added successfully!'); window.location.href = 'beverages_manage.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'beverages_manage.php';</script>";
    }
}

// Query to select products
$sql = "SELECT id, name, description, price, stock, image FROM beverages";
$result = mysqli_query($conn, $sql);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script>
        function validateProductForm() {
            var name = document.getElementById('name').value;
            var description = document.getElementById('description').value;
            var price = document.getElementById('price').value;
            var stock = document.getElementById('stock').value;
            var image = document.getElementById('image').value;

            if (name == "") {
                alert("Product name must be filled out");
                return false;
            }
            if (description == "") {
                alert("Product description must be filled out");
                return false;
            }
            if (price == "" || isNaN(price) || price <= 0) {
                alert("Valid product price must be filled out");
                return false;
            }


            if (stock == "" || isNaN(stock) || stock < 0) {
                alert("Valid product stock must be filled out");
                return false;
            }
            if (image == "") {
                alert("Product image must be selected");
                return false;
            }
            return true;
        }

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

    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .view-products-container {
        width: 90%;
        max-width: 1200px;
        margin: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        }

        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-left: auto; 
            margin-right: auto;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #333;
        }

        th {
            background-color: #1f1f1f;
        }

        tr:nth-child(even) {
            background-color: #1f1f1f;
        }

        tr:hover {
            background-color: #333;
        }

        a {
            color: #bb86fc;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #333;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #bb86fc;
            color: #121212;
        }

        button {
            background-color: #bb86fc;
            color: #121212;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #7f39fb;
        }
        

        h2 {
            margin-bottom: 20px;
            color: #ffffff;
        }

        form {
        display: flex;
        flex-direction: column;
        align-items: left;
        justify-content: center;
        width: 300px;   
        }

        h3 {
            color: #ffffff;
        }

        form {
            background-color: #1f1f1f;
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
            width: 600px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="file"],
        textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            background-color: #333;
            color: #ffffff;
            border: 1px solid #555;
        }

        input[type="file"] {
            padding: 5px;
        }

        textarea {
            height: 100px;
        }

        .manage{
            display: flex;
            justify-content: space-around;
            width: 50%;
            margin-top: 20px;
        }
        
        .manage a{
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #333;
            color: #bb86fc;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        img {
            width: 200px;
            height: 150px;
            object-fit: cover;
        }

        footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px 0;

    width: 100%;
    bottom: 0;
        }
        
    </style>
</head>
<body>
<div class="view-products-container">
    <h2>Additional Food Manage Options</h2>
    <div class="manage">
    <a href="beverages_manage.php">Beverages Manager</a>
    <a href="featured_menu.php">Featured Food Manager</a>
    <a href="promotions.php">Promotion Manager</a>
    </div>
    </div>
    </br>
    <div class="view-products-container">
    <h3>Add New Product</h3> 
    </div>
    <form action="beverages_manage.php" method="post" enctype="multipart/form-data" onsubmit="return validateProductForm()">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="description">Product Description:</label>
        <textarea id="description" name="description" required></textarea>
        <label for="price">Product Price:</label>
        <input type="number" step="0.01" id="price" name="price" required>
        <label for="stock">Product Stock:</label>
        <input type="number" id="stock" name="stock" required>
        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
        <button type="submit">Add Product</button>
    </form>
    <br>


    <div class="view-products-container">
        <h2>Available Products</h2>
        <input type="text" id="searchInput" onkeyup="searchProducts()" placeholder="Search for products..">
        <table id="productsTable">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
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
            /* mysqli_close($conn); */
            ?>

        </table>
        </div>

        <?php include('../partials/footer.php'); ?>
