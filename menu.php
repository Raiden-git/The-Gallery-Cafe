<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="customer_dashboard.css">



    <style>
        body {
    font-family: Arial, sans-serif;

    background-color: #f8f8f8;
    
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

.logout{
    text-decoration: none;
    background-color: green;
    padding: 9px;
    color: white;
    border-radius:8px;
    font-size:15px;
    margin: 7px;
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

            <a class="logout" href="profile.php">Profile</a>

            <div class="nav-buttons">
                <a class="logout" href="logout.php">Logout</a>
            </div>

        </nav>
    </header>
