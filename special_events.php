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

// Query to select special events
$sql = "SELECT id, name, description, date, location, image FROM special_events";
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
    <title>Special Events</title>
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
            left: 50px;
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
            color: white;
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

        .events-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }

        .event-card {
            background-color: #1E1E1E;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px;
            width: 300px;
            overflow: hidden;
            text-align: center;
            border: 1px solid hsl(38, 61%, 73%);
        }

        .event-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .event-card h3 {
            margin: 15px 0 5px;
            font-size: 25px;
        }

        .event-card p {
            margin: 5px 0;
            color: #BBBBBB;
        }

        .event-card .date {
            color: hsl(38, 61%, 73%);
            font-size: 1.2em;
            margin: 10px 0;
        }

        .footer-bottom {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
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
            <li><a href="special_events.php">Special Events</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
        </ul>

        <a class="profile" href="profile.php">Profile</a>

        <div class="nav-buttons">
            <a class="logout" href="logout.php">Logout</a>
        </div>

    </nav>
</header>

<h2>Special Events</h2>

<div class="events-container">
    <?php
    // Check if there are any events in the result set
    if (mysqli_num_rows($result) > 0) {
        // Loop through each event and display it
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="event-card">';
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Event Image"/>';
            echo '<h3>' . $row['name'] . '</h3>';
            echo '<p>' . $row['description'] . '</p>';
            echo '<p class="date">' . $row['date'] . '</p>';
            echo '<p>' . $row['location'] . '</p>';
            echo '</div>';
        }
    } else {
        // Display a message if no events are available
        echo '<p>No events available.</p>';
    }
    // Close the database connection
    mysqli_close($conn);
    ?>
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
