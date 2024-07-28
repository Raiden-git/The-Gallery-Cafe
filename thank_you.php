<?php
if (!isset($_GET['order_id'])) {
    header('Location: index.php');
    exit();
}
$order_id = $_GET['order_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Order Confirmation</h1>
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
        <h2>Thank You for Your Order!</h2>
        <p>Your order number is: <?php echo htmlspecialchars($order_id); ?></p>
        <p>We will send you a confirmation email shortly.</p>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> The Gallery Café. All rights reserved.</p>
    </footer>
</body>
</html>
