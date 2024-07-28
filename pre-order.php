<?php
// Include the database connection file
include('Admin/db_connect.php');
session_start(); // Start the session

// Fetch available food items from the database
$food_result = $conn->query("SELECT * FROM food_items");

// Initialize variables
$customer_name = $customer_email = $order_items = "";
$customer_name_err = $customer_email_err = $order_items_err = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate customer name
    if (empty(trim($_POST["customer_name"]))) {
        $customer_name_err = "Please enter your name.";
    } else {
        $customer_name = trim($_POST["customer_name"]);
    }

    // Validate customer email
    if (empty(trim($_POST["customer_email"]))) {
        $customer_email_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["customer_email"]), FILTER_VALIDATE_EMAIL)) {
        $customer_email_err = "Please enter a valid email.";
    } else {
        $customer_email = trim($_POST["customer_email"]);
    }

    // Validate order items
    if (empty($_POST["order_items"])) {
        $order_items_err = "Please select at least one food item.";
    } else {
        $order_items = $_POST["order_items"];
    }

    // Check for errors before inserting in database
    if (empty($customer_name_err) && empty($customer_email_err) && empty($order_items_err)) {
        // Prepare an insert statement
        $stmt = $conn->prepare("INSERT INTO pre_orders (customer_name, customer_email, order_items) VALUES (?, ?, ?)");
        $order_items_json = json_encode($order_items); // Convert order items array to JSON string
        $stmt->bind_param("sss", $customer_name, $customer_email, $order_items_json);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Pre-order made successfully.';
            header("Location: pre_order.php");
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
    <title>Pre-Order Food - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Pre-Order Food</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="reservations.php">Reservations</a></li>
                <li><a href="pre_order.php">Pre-Order</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <!-- Display message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message success">
                <?php echo htmlspecialchars($_SESSION['message']); ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <form action="pre_order.php" method="POST">
            <div>
                <label for="customer_name">Name:</label>
                <input type="text" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($customer_name); ?>">
                <span class="error"><?php echo $customer_name_err; ?></span>
            </div>
            <div>
                <label for="customer_email">Email:</label>
                <input type="email" id="customer_email" name="customer_email" value="<?php echo htmlspecialchars($customer_email); ?>">
                <span class="error"><?php echo $customer_email_err; ?></span>
            </div>
            <div>
                <label for="order_items">Select Food Items:</label>
                <?php if ($food_result && $food_result->num_rows > 0): ?>
                    <ul>
                        <?php while ($food = $food_result->fetch_assoc()): ?>
                            <li>
                                <input type="checkbox" id="food_<?php echo $food['id']; ?>" name="order_items[]" value="<?php echo $food['name']; ?>">
                                <label for="food_<?php echo $food['id']; ?>"><?php echo htmlspecialchars($food['name']); ?></label>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No food items available.</p>
                <?php endif; ?>
                <span class="error"><?php echo $order_items_err; ?></span>
            </div>
            <div>
                <button type="submit">Pre-Order</button>
            </div>
        </form>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> The Gallery Café. All rights reserved.</p>
    </footer>
</body>
</html>
