<?php
// Start the session
session_start();

// Check if the user is logged in as a customer
if (!isset($_SESSION['username'])/*  || $_SESSION['role'] !== 'customer' */) {
    // Redirect to login page if not a customer
    header("Location: index.html");
    exit();
}

include('admin/db_connect.php');

// Check if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Your cart is empty.'); window.location.href = 'view_products_customer.php';</script>";
    exit();
}

// Handle POST requests for removing items or confirming the order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove'])) {
        // Remove product from cart
        $product_id = $_POST['product_id'];
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
            if (empty($_SESSION['cart'])) {
                unset($_SESSION['cart']);
            }
            echo "<script>alert('Product removed from cart!'); window.location.href = 'view_cart.php';</script>";
        }
    } elseif (isset($_POST['confirm_order'])) {
        // Confirm the order
        $customer_id = $_SESSION['user_id'];
        $product_ids = implode(',', array_keys($_SESSION['cart']));
        $quantities = implode(',', $_SESSION['cart']);
        $total = $_POST['total'];

        // Insert order into the database
        $sql = "INSERT INTO orders (customer_id, product_ids, quantities, total) VALUES ('$customer_id', '$product_ids', '$quantities', '$total')";

        if (mysqli_query($conn, $sql)) {
            $order_id = mysqli_insert_id($conn);
            $order_summary = "Order ID: " . $order_id . "\\n";
            foreach ($_SESSION['cart'] as $id => $quantity) {
                $sql = "SELECT name FROM menu WHERE id='$id'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $order_summary .= $row['name'] . " (Quantity: $quantity)\\n";
                }
            }
            $order_summary .= "Total: $$total";
            unset($_SESSION['cart']);
            echo "<script>alert('Order confirmed!\\n$order_summary'); window.location.href = 'view_products_customer.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'view_cart.php';</script>";
        }
    }
}

// Get the product IDs from the cart
$cart = $_SESSION['cart'];
$product_ids = implode(',', array_keys($cart));

// Query to get product details for items in the cart
$sql = "SELECT id, name, price FROM menu WHERE id IN ($product_ids)
UNION
SELECT id, name, price FROM beverages WHERE id IN ($product_ids)";
$result = mysqli_query($conn, $sql);
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
    <title>View Cart</title>
    <style>
        body {
            background-color: #1e1e1e;
            color: #f5f5f5;
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
            margin-top: 20px;
        }
        table {
            width: 80%;
            max-width: 800px;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #444444;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #2e2e2e;
        }
        .action-column {
            width: 120px;
        }
        .total {
            text-align: right;
            margin-bottom: 20px;
            width: 80%;
            max-width: 800px;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        button, .back-link {
            background-color: hsl(38, 61%, 73%);
            border: 1px solid hsl(38, 61%, 73%);
            color: #1e1e1e;
            padding: 5px 15px;
            text-decoration: none;
            cursor: pointer;
            display: inline-block;
        }
        button:hover, .back-link:hover {
            background-color: transparent;
            color: hsl(38, 61%, 73%);
        }
        .remove-button {
            width: 100%;
            padding: 5px;
        }
        .confirm-button {
            width: auto;
            padding: 10px;
        }
        
        .center{
            display: flex;
            flex-direction: column;
            align-items:center;
        }

        .btn{
            position: relative;
            left:50px;
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
                <li><a href="#">Promotions</a></li>
                <li><a href="#">Special Events</a></li>
                <li><a href="contact_us.html">Contact Us</a></li>
            </ul>

            <a class="profile" href="profile.php">Profile</a>

            <div class="nav-buttons">
                <a class="logout" href="logout.php">Logout</a>
            </div>

        </nav>
    </header>

<div class="center">
    <h2>Your Cart</h2>
    
    <table>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th class="action-column">Action</th>
        </tr>
        <?php
        $total = 0;
        // Check if there are any products in the result set
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $quantity = $cart[$row['id']];
                $subtotal = $row['price'] * $quantity;
                $total += $subtotal;
                echo '<tr>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>Rs.' . $row['price'] . '</td>';
                echo '<td>' . $quantity . '</td>';
                echo '<td>Rs.' . $subtotal . '</td>';
                echo '<td class="action-column">';
                echo '<form method="post" action="view_cart.php" style="margin: 0;">';
                echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                echo '<button type="submit" name="remove" class="remove-button">Remove</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        }
        // Close the database connection
        mysqli_close($conn);
        ?>
    </table>
    <div class="total">
        <strong>Total: Rs.<?php echo $total; ?></strong>
        <div class="buttons">
            <a href="view_products_customer.php" class="back-link">Continue Shopping</a>
            <form method="post" action="view_cart.php">
                <input type="hidden" name="total" value="<?php echo $total; ?>">
                <button type="submit" name="confirm_order" class="confirm-button">Confirm Order</button>
            </form>
        </div>
    </div>
</div>

<footer>

    <div class="footer-bottom">
    
    <p class="copyright">
      © 2024 The Gallery Café. All Rights Reserved
    </p>

  </div>
</footer>

</body>
</html>

