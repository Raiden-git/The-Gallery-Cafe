<?php include('../partials/menu.php'); ?>

<?php

include('db_connect.php');
include('session_check.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $date = $_POST['date'];

    // Retrieve and process the image file
    $image = $_FILES['image']['tmp_name'];
    $imgContent = addslashes(file_get_contents($image));

    // Insert new product into the database
    $sql = "INSERT INTO promotions (name, description, price, date, image) VALUES ('$name', '$description', '$price', '$date', '$imgContent')";

    // Execute the query and check if it was successful
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product added successfully!'); window.location.href = 'promotions.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'promotions.php';</script>";
    }
}

// Query to select products
$sql = "SELECT id, name, description, price, date, image FROM promotions";
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
    <link rel="stylesheet" href="styles.css">
    <script>
        function validateProductForm() {
            var name = document.getElementById('name').value;
            var description = document.getElementById('description').value;
            var price = document.getElementById('price').value;
            var category = document.getElementById('date').value;
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

            if (date == "") {
                alert("Food added date must be filled out");
                return false;
            }

            if (image == "") {
                alert("Food image must be selected");
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
        .logout {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .logout a {
            text-decoration: none;
            color: white;
            background-color: #ff4b4b;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .logout a:hover {
            background-color: #ff0000;
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

        img {
            width: 200px;
            height: 150px;
            object-fit: cover;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        form {
    display: flex;
    flex-direction: column;
    align-items: left;
    justify-content: center;
    width: 300px;

    
}

        
    </style>
</head>
<body>
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>

    <h3>Add New Product</h3>
    <form action="promotions.php" method="post" enctype="multipart/form-data" onsubmit="return validateProductForm()">

        <label for="name">Promotion Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Promotion Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required>

        <label for="category">Date:</label>
        <input type="date" id="date" name="date" required>

        <label for="image">Image:</label>
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
                <th>Date</th>
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
                    echo "<td>" . $row['date'] . "</td>";
                    echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Product Image"/></td>';
                    echo '<td>';
                    echo '<a href="edit_promo.php?id=' . $row['id'] . '">Edit</a> | ';
                    echo '<a href="delete_promo.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>';
                    echo '</td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No products found</td></tr>";
            }
            // Close the database connection
            /* mysqli_close($conn); */
            ?>

</body>
</html>
