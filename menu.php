<?php
// Fetch food items from the database and display them
include('Admin/db_connect.php');
$result = $conn->query("SELECT * FROM food_items");

while ($row = $result->fetch_assoc()):
?>
    <div class="food-item">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p><?php echo htmlspecialchars($row['description']); ?></p>
        <p>Price: <?php echo number_format($row['price'], 2); ?></p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="item_id" value="<?php echo $row['id']; ?>">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" value="1" min="1">
            <input type="hidden" name="action" value="add">
            <button type="submit">Add to Cart</button>
        </form>
    </div>
<?php
endwhile;
$conn->close();
?>
