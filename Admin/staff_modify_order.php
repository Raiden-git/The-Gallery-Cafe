<?php
// Include the database connection file
include('../admin/db_connect.php');
include('session_check.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch pre-order details for the given ID
if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM pre_orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pre_order = $result->fetch_assoc();
    $stmt->close();

    if (!$pre_order) {
        die('Pre-order not found.');
    }
} else {
    die('Invalid pre-order ID.');
}

// Handle form submission to update pre-order details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];
    $order_date = $_POST['order_date'];
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE pre_orders SET customer_name = ?, order_date = ?, product_id = ?, quantity = ?, status = ? WHERE id = ?");
    $stmt->bind_param("ssiiii", $customer_name, $order_date, $product_id, $quantity, $status, $order_id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Pre-order updated successfully.';
        header("Location: staff_order.php");
        exit();
    } else {
        $error_message = 'Error: ' . $stmt->error;
    }

    $stmt->close();
}

// Fetch available products for the dropdown
$products_result = $conn->query("SELECT id, name FROM menu");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Pre-Order</title>
    <style>
        body {
            background-color: #2c2c2c;
            color: #f5f5f5;
            font-family: Arial, sans-serif;
            
        }

        .full {
            position: relative;
            top: -10px;
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
        }
        
        h1 {
            color: #fff;
        }
        .container {
            margin: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, select, button {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: none;
            width: 100%;
            max-width: 300px;
        }
        input, select {
            background-color: #444;
            color: #f5f5f5;
        }
        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: #ff6b6b;
        }
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #444;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: #f5f5f5;
            position: relative;
            left:250px;
            top: 50px;;
        }
        .back-button:hover {
            background-color: #333;
        }
    </style>
</head>
<body>

<a href="order_management.php" class="back-button">← Back</a>
    <div class="full">
    <h1>Modify Pre-Order</h1>

    <?php if (isset($error_message)): ?>
        <div class="error">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <form action="staff_modify_order.php?id=<?php echo $order_id; ?>" method="POST">
        <label for="customer_name">Customer Name:</label>
        <input type="text" name="customer_name" id="customer_name" value="<?php echo htmlspecialchars($pre_order['customer_name']); ?>" required><br>

        <label for="order_date">Order Date:</label>
        <input type="datetime-local" name="order_date" id="order_date" value="<?php echo htmlspecialchars($pre_order['order_date']); ?>" required><br>

        <label for="product_id">Product:</label>
        <select name="product_id" id="product_id" required>
            <?php while ($product = $products_result->fetch_assoc()): ?>
                <option value="<?php echo $product['id']; ?>" <?php echo $product['id'] == $pre_order['product_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($product['name']); ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($pre_order['quantity']); ?>" required><br>

        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="Pending" <?php echo $pre_order['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="Confirmed" <?php echo $pre_order['status'] == 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
        </select><br>

        <button type="submit">Update Pre-Order</button>
    </form>

    </div>

    <?php
    // Close the connection
    $conn->close();
    ?>
</body>
</html>
