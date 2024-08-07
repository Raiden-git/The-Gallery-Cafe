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

// Fetch customer details
$customer_name = $_SESSION['username'];
$sql_customer = "SELECT * FROM customers WHERE username = '$customer_name'";
$result_customer = mysqli_query($conn, $sql_customer);
$customer = mysqli_fetch_assoc($result_customer);

// Fetch user details
$sql = "SELECT * FROM customers WHERE username = '$customer_name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Fetch reservation details
$sql = "SELECT * FROM reservations WHERE customer_name = '".$user['full_name']."'";
$reservation_result = $conn->query($sql);

// Fetch pre-order details
$sql_pre_orders = "SELECT pre_orders.id, menu.name AS product_name, pre_orders.quantity, pre_orders.status 
                   FROM pre_orders 
                   JOIN menu ON pre_orders.product_id = menu.id 
                   WHERE pre_orders.customer_name = '$customer_name'";
$result_pre_orders = mysqli_query($conn, $sql_pre_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">


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

.container {
    display: flex;
    justify-content: space-around;
    padding: 20px;
}

.card {
    background-color: #1e1e1e;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 25px;
    width: 28%;
    border:1px solid hsl(38, 61%, 73%);
}

.card h1, .card h2 {
    color: #FF6F61;
}

.card p, .card table {
    margin: 10px 0;
}

.card table {
    width: 100%;
    border-collapse: collapse;
}

.card table th, .card table td {
    border: 1px solid #444;
    padding: 10px;
    text-align: left;
}

.card table th {
    background-color: #333;
}

.card table td {
    background-color: #1e1e1e;
}

.card hr {
    border: 0;
    border-top: 1px solid #444;
}

.footer-bottom{
            display: flex;
            justify-content:center;
            align-items:center;
            padding:20px;
            background-color: #333;
        }


.logout {
  position: relative;
  left: 55px;
  text-decoration: none;
  background-color: hsl(38, 61%, 73%);
  padding: 8px 17px;
  color: black;
  font-size: 16px;
  margin: 5px;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.logout:hover {
  background-color: #333;
  border: 1px solid hsl(38, 61%, 73%);
  color: white;
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
                <li><a href="special_events.php">Special Events</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
            </ul>

                <a class="logout" href="logout.php">Logout</a>

        </nav>
    </header>


    <div class="container">
        <div class="profile card">
            <h1>Welcome, <?php echo $user['full_name']; ?></h1>
            <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Full Name:</strong> <?php echo $user['full_name']; ?></p>
            <p><strong>Contact Number:</strong> <?php echo $user['contact_number']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Address:</strong> <?php echo $user['address']; ?></p>
            <p><strong>Gender:</strong> <?php echo $user['gender']; ?></p>
        </div>
        <div class="reservations card">
            <h2>Your Reservations</h2>
            <?php
            if ($reservation_result->num_rows > 0) {
                while($reservation = $reservation_result->fetch_assoc()) {
                    echo "<p><strong>Reservation Date:</strong> " . $reservation['reservation_date'] . "</p>";
                    echo "<p><strong>Number of Guests:</strong> " . $reservation['number_of_guests'] . "</p>";
                    echo "<p><strong>Contact Number:</strong> " . $reservation['contact_number'] . "</p>";
                    echo "<p><strong>Status:</strong> " . $reservation['status'] . "</p>";
                    echo "<hr>";
                }
            } else {
                echo "<p>No reservations found.</p>";
            }
            ?>
        </div>
        <div class="pre-orders card">
            <h2>Your Pre-Orders</h2>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Confirmation Status</th>
                </tr>
                <?php
                if (mysqli_num_rows($result_pre_orders) > 0) {
                    while ($row = mysqli_fetch_assoc($result_pre_orders)) {
                        echo '<tr>';
                        echo '<td>' . $row['product_name'] . '</td>';
                        echo '<td>' . $row['quantity'] . '</td>';
                        echo '<td>' . $row['status'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="3">No pre-orders found.</td></tr>';
                }
                ?>
            </table>
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

<?php
// Close the database connection
mysqli_close($conn);
?>
