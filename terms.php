<?php
// Start the session
session_start();

// Check if the user is logged in as customer
if (!isset($_SESSION['username'])) {
    // If not logged in as customer, redirect to login page
    header("Location: index.html");
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Café</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="customer_dashboard.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
    background-color: #141414;
    color: #333;
}
        .container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.title{
    color: white;
}

header {
    text-align: center;
    margin-bottom: 20px;
}

header h1 {
    margin: 0;
    color: #444;
}

header p {
    color: #777;
    font-size: 0.9em;
}

section {
    margin-bottom: 20px;
}

section h2 {
    color: #444;
    border-bottom: 2px solid #ddd;
    padding-bottom: 5px;
    align-items: left;
}

section p, section ul {
    margin: 10px 0;
}

section ul {
    list-style-type: disc;
    padding-left: 20px;
}

footer {
    text-align: center;
    margin-top: 20px;
    padding-top: 10px;
    border-top: 1px solid #ddd;
    color: #777;
}

footer p {
    margin: 0;
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

            <a href="profile.php" class="profile">Hi, <?php echo ($username); ?></a>

            <div class="nav-buttons">
                <a class="logout" href="logout.php">Logout</a>
            </div>

        </nav>
    </header>

    <div class="container">
        <header>
            <h1 class="title">Terms and Conditions</h1>
            <p>Effective Date: August 7, 2024</p>
        </header>
        
        <section>
            <h2>1. Introduction</h2>
            <p>Welcome to The Gallery Café's website. By accessing or using our website, you agree to comply with and be bound by the following terms and conditions. If you do not agree with these terms, please do not use our website.</p>
        </section>

        <section>
            <h2>2. Use of the Website</h2>
            <ul>
                <li>You must be at least 18 years old to use our website.</li>
                <li>You agree to use the website only for lawful purposes and in a way that does not infringe the rights of, restrict, or inhibit anyone else's use of the website.</li>
                <li>You are responsible for maintaining the confidentiality of your account information and password and for restricting access to your computer.</li>
            </ul>
        </section>

        <section>
            <h2>3. Reservations and Orders</h2>
            <ul>
                <li>All reservations and food orders made through our website are subject to confirmation and availability.</li>
                <li>We reserve the right to refuse any reservation or order at our discretion.</li>
                <li>Changes or cancellations to reservations must be made according to our cancellation policy, which is available on our website.</li>
            </ul>
        </section>

        <section>
            <h2>4. Intellectual Property</h2>
            <p>All content on the website, including text, graphics, logos, images, and software, is the property of The Gallery Café or its content suppliers and is protected by international copyright laws. You may not reproduce, distribute, or create derivative works from any part of our website without our express written permission.</p>
        </section>

        <section>
            <h2>5. Limitation of Liability</h2>
            <p>The Gallery Café shall not be liable for any damages arising from the use or inability to use the website or from any content posted on the website. Our liability for any claim arising out of or in connection with any services provided via the website shall be limited to the amount paid by you for such services.</p>
        </section>

        <section>
            <h2>6. Changes to Terms and Conditions</h2>
            <p>We reserve the right to modify these terms and conditions at any time. Your continued use of the website following any changes will indicate your acceptance of the new terms.</p>
        </section>
        
        <footer>
            <p>&copy; 2024 The Gallery Café. All rights reserved.</p>
        </footer>
    </div>