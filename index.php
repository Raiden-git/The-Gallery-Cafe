<?php
// Include the database connection file
include('Admin/db_connect.php');

// Fetch meals, menus, and special items from the database
$meals_result = $conn->query("SELECT * FROM food_items");
/* $menus_result = $conn->query("SELECT * FROM menus");
$specials_result = $conn->query("SELECT * FROM specials"); */

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Café - Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome to The Gallery Café</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="reservations.php">Reservations</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="meals">
            <h2>Types of Meals</h2>
            <?php if ($meals_result && $meals_result->num_rows > 0): ?>
                <ul>
                    <?php while ($meal = $meals_result->fetch_assoc()): ?>
                        <li><?php echo htmlspecialchars($meal['name']); ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No meals available.</p>
            <?php endif; ?>
        </section>

        <section id="menus">
            <h2>Menus</h2>
            <?php if ($menus_result && $menus_result->num_rows > 0): ?>
                <ul>
                    <?php while ($menu = $menus_result->fetch_assoc()): ?>
                        <li><?php echo htmlspecialchars($menu['name']); ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No menus available.</p>
            <?php endif; ?>
        </section>

        <section id="specials">
            <h2>Special Food & Beverages</h2>
            <?php if ($specials_result && $specials_result->num_rows > 0): ?>
                <ul>
                    <?php while ($special = $specials_result->fetch_assoc()): ?>
                        <li><?php echo htmlspecialchars($special['name']); ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No special items available.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> The Gallery Café. All rights reserved.</p>
    </footer>
</body>
</html>
