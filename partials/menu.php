<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
    <title>System Admin Dashboard</title>
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #1a1a1a;
    color: #f0f0f0;
}

/* Header Styles */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #333;
    border-bottom: 2px solid #444;
    flex-wrap: nowrap; /* Prevent wrapping of content */
}

/* Navbar Styles */
.navbar {
    display: flex;
    align-items: center;
    flex-wrap: nowrap; /* Prevent wrapping of menu items */
}

.nav-menu {
    position: relative;
    left:-50px;
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-wrap: nowrap; /* Prevent wrapping of menu items */
}

.nav-menu li {
    margin-right: 5px; /* Reduce spacing between menu items */
}

.nav-menu li a {
    text-decoration: none;
    color: #f0f0f0;
    font-size: 14px; /* Smaller font size to fit more items */
    padding: 5px 8px; /* Adjust padding */
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.nav-menu li a:hover {
    background-color: #555;
}

/* Logout Button Styles */
.nav-button .logout {
    text-decoration: none;
    background-color: #ff4c4c;
    color: #ffffff;
    font-size: 14px; /* Match the font size of menu items */
    padding: 8px 12px; /* Adjust padding */
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.nav-button .logout:hover {
    background-color: #ff1a1a;
}

.logo {
    position: relative;
   color: white; 
   font-size: 50px; 
   font-family: Italianno;
   font-weight: 400;
   top: 0px;
   left: 0px;
}

    </style>

</head>
<body>
    <header>
        <div class="logo">
            The Gallery Café
        </div>
        <nav class="navbar">
            <ul class ="nav-menu">
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="admin_dashboard.php">Food Management</a></li>
                <li><a href="reservation_management.php">Reservation Management</a></li>
                <li><a href="parking_manage.php">Parking Management</a></li>
                <li><a href="order_management.php">Order Management</a></li>
                <li><a href="manage_special_events.php">Special Event Manage</a></li>

            </ul>
            <div class="nav-button">
                <a class="logout" href="logout.php">Logout</a>
            </div>
        </nav>
    </header>