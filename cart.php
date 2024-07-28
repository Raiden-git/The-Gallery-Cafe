<?php
session_start();

// Include the database connection file
include('Admin/db_connect.php');

// Initialize cart if not already initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add item to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    
    if (isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id] += $quantity;
    } else {
        $_SESSION['cart'][$item_id] = $quantity;
    }

    header('Location: cart.php');
    exit();
}

// Update item quantity in cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    
    if ($quantity <= 0) {
        unset($_SESSION['cart'][$item_id]);
    } else {
        $_SESSION['cart'][$item_id] = $quantity;
    }

    header('Location: cart.php');
    exit();
}

// Calculate total amount
$total_amount = 0;
$cart_items = [];
foreach ($_SESSION['cart'] as $item_id => $quantity) {
    $stmt = $conn->prepare("SELECT * FROM food_items WHERE id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();

    if ($item) {
        $item['quantity'] = $quantity;
        $item['total'] = $item['price'] * $quantity;
        $total_amount += $item['total'];
        $cart_items[] = $item;
    }

    $stmt->close();
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Cart</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="reservations.php">Reservations</a></li>
                <li><a href="pre_order.php">Pre-Order</a></li>
                <li><a href="search.php">Search</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Your Cart</h2>
        <?php if (!empty($cart_items)): ?>
            <form action="cart.php" method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo number_format($item['price'], 2); ?></td>
                                <td>
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>">
                                    <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                                </td>
                                <td><?php echo number_format($item['total'], 2); ?></td>
                                <td>
                                    <button type="submit" name="action" value="update">Update</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p>Total Amount: <?php echo number_format($total_amount, 2); ?></p>
                <button type="submit">Update Cart</button>
            </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> The Gallery Café. All rights reserved.</p>
    </footer>
</body>
</html>
