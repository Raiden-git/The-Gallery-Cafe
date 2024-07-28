<?php
// Include the database connection file
include('Admin/db_connect.php');

// Initialize variables
$search_query = "";
$search_result = [];
$search_err = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Validate search query
    if (empty(trim($_GET["query"]))) {
        $search_err = "Please enter a cuisine type.";
    } else {
        $search_query = trim($_GET["query"]);
        
        // Prepare a select statement
        $stmt = $conn->prepare("SELECT * FROM food_items WHERE cuisine_type LIKE ?");
        $search_term = "%{$search_query}%";
        $stmt->bind_param("s", $search_term);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $search_result[] = $row;
            }
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
    <title>Search Food - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Search Food</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="reservations.php">Reservations</a></li>
                <li><a href="pre_order.php">Pre-Order</a></li>
                <li><a href="search.php">Search</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form action="search.php" method="GET">
            <div>
                <label for="query">Search Cuisine Type:</label>
                <input type="text" id="query" name="query" value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit">Search</button>
                <span class="error"><?php echo $search_err; ?></span>
            </div>
        </form>
        <div>
            <?php if (!empty($search_result)): ?>
                <h2>Search Results:</h2>
                <ul>
                    <?php foreach ($search_result as $food): ?>
                        <li><?php echo htmlspecialchars($food['name']) . " - " . htmlspecialchars($food['cuisine_type']); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php elseif (!empty($search_query) && empty($search_err)): ?>
                <p>No results found for "<?php echo htmlspecialchars($search_query); ?>".</p>
            <?php endif; ?>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> The Gallery Café. All rights reserved.</p>
    </footer>
</body>
</html>
