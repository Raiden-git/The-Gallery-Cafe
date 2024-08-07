<?php
// Start the session
session_start();

// Check if the user is logged in as a customer
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not a customer
    header("Location: index.html");
    exit();
}

include('admin/db_connect.php');

// Handle search and filter
$search_query = "";
$filter_category = "";
$sql_conditions = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['search'])) {
        $search_query = mysqli_real_escape_string($conn, $_GET['search']);
        $sql_conditions[] = "name LIKE '%$search_query%'";
    }
    if (isset($_GET['category']) && $_GET['category'] != "") {
        $filter_category = mysqli_real_escape_string($conn, $_GET['category']);
        $sql_conditions[] = "category = '$filter_category'";
    }
}

// Query to select product details with search and filter conditions
$sql = "SELECT id, name, description, category, price, stock, image FROM menu";
if (!empty($sql_conditions)) {
    $sql .= " WHERE " . implode(" AND ", $sql_conditions);
}
$result = mysqli_query($conn, $sql);

// Handle adding products to the cart or pre-ordering
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $customer_name = $_SESSION['username'];

    // Check if adding to cart or pre-ordering
    if (isset($_POST['add_to_cart'])) {
        // Initialize the cart if not already set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Update the cart with the new product or add a new product
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }

        // Alert user and redirect to product view page
        echo "<script>alert('Product added to cart!'); window.location.href = 'view_products_customer.php';</script>";
    } elseif (isset($_POST['pre_order'])) {
        // Insert pre-order into the database
        $stmt = $conn->prepare("INSERT INTO pre_orders (customer_name, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $customer_name, $product_id, $quantity);
        $stmt->execute();
        $stmt->close();

        // Alert user and redirect to product view page
        echo "<script>alert('Product pre-ordered!'); window.location.href = 'view_products_customer.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
    <title>Available Products</title>
    <style>
        body {
            background-color: #121212;
            color: #FFFFFF;
            font-family: 'DM Sans', sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
    width: 100%;
    background-color: #333;
    padding: 10px 0;
}

        .navbar {

    max-width: 1200px;
    width: 100%;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
}

.logo {
    position: relative;
   color: white; 
   font-size: 50px; 
   font-family: Italianno;
   font-weight: 400;
   top: 0px;
   left: 40px;
}

.nav-menu {
    list-style: none;
    display: flex;
    gap: 20px;
    margin: 0;
    padding: 0;
}

.nav-menu li {
    display: inline;
    position: relative;
    left:50px;
}

.nav-menu a {
    color: #fff;
    text-decoration: none;
    font-size: 1em;
}

.nav-buttons {
    display: flex;
    gap: 10px;
}

.profile {
  position: relative;
  left: 50px;
  text-decoration: none;
  color:white;
  background-color: #333;
  border: 1px solid hsl(38, 61%, 73%);
  border-radius: 20px;
  padding: 10px 20px;
  font-size: 16px;
  margin: 5px;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.profile:hover {
  color: hsl(38, 61%, 73%);
}

.logout {
  position: relative;
  left: 55px;
  text-decoration: none;
  background-color: hsl(38, 61%, 73%);
  padding: 8px 17px;
  color: black;
  border: 1px solid hsl(38, 61%, 73%);
  font-size: 16px;
  margin: 5px;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.logout:hover {
  background-color: #333;
  color: white;
}

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        .form-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .form-container input[type="text"], .form-container select, .form-container button {
            margin: 0 10px;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }

        .form-container input[type="text"] {
            width: 200px;
        }

        .form-container select {
            width: 150px;
        }

        .form-container button {
            background-color: #333;
            color: #FFFFFF;
            border:1px solid hsl(38, 61%, 73%);
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: hsl(38, 61%, 73%);
            color:black;
        }

        .products-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }

        .product-card {
            background-color: #1E1E1E;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px;
            width: 300px;
            overflow: hidden;
            text-align: center;
            border:1px solid hsl(38, 61%, 73%);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-card h3 {
            margin: 15px 0 5px;
            font-size:25px;
        }

        .product-card p {
            margin: 5px 0;
            color: #BBBBBB;
        }

        .product-card .price {
            color: hsl(38, 61%, 73%);
            font-size: 1.2em;
            margin: 10px 0;
        }

        .product-card form {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 0;
        }

        .product-card input[type="number"] {
            width: 60px;
            padding: 5px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
        }

        .product-card button {
  background-color: hsl(38, 61%, 73%);
  color: black;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  margin: 5px 0;
}

.product-card button:hover {
  background-color: #4044414f;
  border: 1px solid hsl(38, 61%, 73%);
  color:white;
}

        .fixed-cart-link {
            position: fixed;
            right: 20px;
            bottom: 20px;
            background-color: #1DB954;
            color: #FFFFFF;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-weight: bold;
        }

        .fixed-cart-link:hover {
            background-color: #1AA34A;
        }

        .cart-link {
            display: block;
            text-align: center;
            margin: 20px 0;
            color: #1DB954;
            text-decoration: none;
        }

        .cart-link:hover {
            color: #1AA34A;
        }

        .footer-bottom{
            display: flex;
            justify-content:center;
            align-items:center;
            padding:20px;
            background-color: #333;
        }


    </style>
</head>
<body>

<header>
        <nav class="navbar">
            <div class="logo">The Gallery Café</div>
            <ul class="nav-menu">
                <li><a href="customer_dashboard.php">Home</a></li>
                <li><a href="view_products_customer.php">Menu</a></li>
                <li><a href="#">Special Events</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
            </ul>

            <a class="profile" href="profile.php">Profile</a>

            <div class="nav-buttons">
                <a class="logout" href="logout.php">Logout</a>
            </div>

        </nav>
    </header>


    <h2>Available Products</h2>
    <div class="form-container">
        <form method="get" action="view_products_customer.php">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search by name">
            <select name="category">
                <option value="">All Categories</option>
                <option value="Sri lankan" <?php if ($filter_category == "Sri lankan") echo "selected"; ?>>Srilankan</option>
                <option value="Tamil" <?php if ($filter_category == "Tamil") echo "selected"; ?>>Tamil</option>
                <option value="Chinese" <?php if ($filter_category == "Chinese") echo "selected"; ?>>Chinese</option>
                <option value="English" <?php if ($filter_category == "English") echo "selected"; ?>>English</option>
                <!-- Add more categories as needed -->
            </select>
            <button type="submit">Search & Filter</button>
        </form>
    </div>
    <div class="products-container">
        <?php
        // Check if there are any products in the result set
        if (mysqli_num_rows($result) > 0) {
            // Loop through each product and display it
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="product-card">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Product Image"/>';
                echo '<p>(' . $row['category'] . ')</p>';
                echo '<h3>' . $row['name'] . '</h3>';
                
                
                echo '<p>' . $row['description'] . '</p>';
                
                echo '<p class="price">Rs.' . $row['price'] . '</p>';
                echo '<form method="post" action="view_products_customer.php">';
                echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                echo '<input type="number" name="quantity" value="1" min="1" max="' . $row['stock'] . '" required>';
                echo '<button type="submit" name="add_to_cart">Add to Cart</button>';
                echo '<button type="submit" name="pre_order">Pre-Order</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            // Display a message if no products are available
            echo '<p>No products available.</p>';
        }
        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>
    

    <a href="view_cart.php" class="fixed-cart-link">View Cart</a>
    <footer>

    <div class="footer-bottom">
    
    <p class="copyright">
      © 2024 The Gallery Café. All Rights Reserved
    </p>

  </div>
</footer>
 
</body>
</html>
