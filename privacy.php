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
            <h1 class="title">Privacy Policy</h1>
            <p>Effective Date: August 7, 2024</p>
        </header>
        
        <section>
            <h2>1. Introduction</h2>
            <p>The Gallery Café respects your privacy and is committed to protecting your personal data. This privacy policy explains how we collect, use, and share your personal information.</p>
        </section>

        <section>
            <h2>2. Information We Collect</h2>
            <ul>
                <li><strong>Personal Information:</strong> We may collect personal information such as your name, email address, phone number, and payment information when you make a reservation or place an order.</li>
                <li><strong>Non-Personal Information:</strong> We may collect non-personal information such as browser type, operating system, and website usage data through cookies and similar technologies.</li>
            </ul>
        </section>

        <section>
            <h2>3. How We Use Your Information</h2>
            <ul>
                <li><strong>To Provide Services:</strong> We use your personal information to process reservations, orders, and payments, and to communicate with you about your bookings and orders.</li>
                <li><strong>To Improve Our Website:</strong> We use non-personal information to analyze website usage and improve our website's functionality and user experience.</li>
                <li><strong>Marketing:</strong> With your consent, we may use your personal information to send you promotional materials and special offers. You can opt-out of these communications at any time.</li>
            </ul>
        </section>

        <section>
            <h2>4. Sharing Your Information</h2>
            <ul>
                <li><strong>Service Providers:</strong> We may share your personal information with third-party service providers who assist us in operating our website and providing our services.</li>
                <li><strong>Legal Requirements:</strong> We may disclose your personal information if required to do so by law or in response to valid requests by public authorities.</li>
            </ul>
        </section>

        <section>
            <h2>5. Data Security</h2>
            <p>We implement appropriate technical and organizational measures to protect your personal data against unauthorized access, alteration, disclosure, or destruction. Despite these measures, please be aware that no data transmission over the internet is completely secure. We cannot guarantee the security of your data transmitted to our website.</p>
        </section>

        <section>
            <h2>6. Your Rights</h2>
            <p>You have the right to access, correct, or delete your personal information held by us. You also have the right to object to or restrict certain types of data processing. To exercise these rights, please contact us using the information provided on our website.</p>
        </section>

        <section>
            <h2>7. Changes to Privacy Policy</h2>
            <p>We reserve the right to update this privacy policy at any time. Any changes will be posted on this page, and we encourage you to review our privacy policy periodically.</p>
        </section>
        
        <footer>
            <p>&copy; 2024 The Gallery Café. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>