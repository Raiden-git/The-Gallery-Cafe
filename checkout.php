<?php
session_start();

// Include the database connection file
include('Admin/db_connect.php');

// Redirect if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

// Initialize variables
$name = $email = $phone = $address = "";
$name_err = $email_err = $phone_err = $address_err = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate phone
    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Please enter your phone number.";
    } elseif (!preg_match('/^[0-9]{10}$/', trim($_POST["phone"]))) {
        $phone_err = "Please enter a valid 10-digit phone number.";
    } else {
        $phone = trim($_POST["phone"]);
    }

    // Validate address
    if (empty(trim($_POST["address"]))) {
        $address_err = "Please enter your address.";
    } else {
        $address = trim($_POST["address"]);
    }

    // Check for errors before inserting in database
    if (empty($name_err) && empty($email_err) && empty($phone_err) && empty($address_err)) {
        // Prepare an insert statement for the order
        $stmt = $conn->prepare("INSERT INTO orders (name, email, phone, address, total_amount) VALUES (?, ?, ?, ?, ?)");
        $total_amount = 0;
        foreach ($_SESSION['cart'] as $item_id => $quantity) {
            $stmt_item = $conn->prepare("SELECT * FROM food_items WHERE id = ?");
            $stmt_item->bind_param("i", $item_id);
            $stmt_item->execute();
            $result_item = $stmt_item->get_result();
            $item = $result_item->fetch_assoc();

            if ($item) {
                $total_amount += $item['price'] * $quantity;
            }

            $stmt_item->close();
        }
        $stmt->bind_param("ssssd", $name, $email, $phone, $address, $total_amount);

        if ($stmt->execute()) {
            $order_id = $stmt->insert_id;

            // Insert order items
            foreach ($_SESSION['cart'] as $item_id => $quantity) {
                $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, item_id, quantity) VALUES (?, ?, ?)");
                $stmt_item->bind_param("iii", $order_id, $item_id, $quantity);
                $stmt_item->execute();
                $stmt_item->close();
            }

            // Clear the cart
            unset($_SESSION['cart']);

            // Redirect to a thank you page
            header("Location: thank_you.php?order_id=" . $order_id);
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Checkout</h1>
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
        <h2>Confirm Your Order</h2>
        <form action="checkout.php" method="POST">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
                <span class="error"><?php echo $name_err; ?></span>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            <div>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                <span class="error"><?php echo $phone_err; ?></span>
            </div>
            <div>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>">
                <span class="error"><?php echo $address_err; ?></span>
            </div>
            <button type="submit">Place Order</button>
        </form>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> The Gallery Café. All rights reserved.</p>
    </footer>
</body>
</html>
