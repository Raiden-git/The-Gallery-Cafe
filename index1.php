<?php
include 'Admin/db_connect.php';

$result = $conn->query("SELECT * FROM food_items");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Menu</title>
    <link rel="stylesheet" href="menu.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">LOGO</div>
            <ul class="nav-menu">
                <li><a href="#">Home</a></li>
                <li><a href="view_products_customer.php">Menu</a></li>
                <li><a href="#">Reservation</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Special Offers</a></li>
            </ul>
            <div class="nav-buttons">
                <button class="cart-btn">Cart <span id="cart-count">0</span></button>
                <button class="login-btn">Login</button>
            </div>
        </nav>
    </header>

    <div class="menu-container">
        <h1 class="menu-title">Our Menu</h1>

        <div class="menu-grid" id="menu-grid">
            <?php if ($result->num_rows > 0):?>
                <?php while($row = $result->fetch_assoc()):?>
                    <div class="menu-item" data-id="<?= $row['id']?>" data-name="<?= $row['name']?>" data-price="<?= $row['price']?>" data-image="<?= $row['image_url']?>">
                        <img src="<?= $row['image_url']?>" alt="<?= $row['name']?>" class="menu-item-image">
                        <h3><?= $row['name']?></h3>
                        <p><?= $row['description']?></p>
                        <div class="menu-item-details">
                            <span class="menu-item-price">$<?= $row['price']?></span>
                            <div class="menu-item-quantity">
                                <label for="<?= $row['name']?>-quantity">Qty:</label>
                                <input type="number" id="<?= $row['name']?>-quantity" name="<?= $row['name']?>-quantity" min="1" value="1">
                            </div>
                            <button class="add-to-cart-btn" data-id="<?= $row['id']?>">Add to Cart</button>
                        </div>
                    </div>
                <?php endwhile;?>
            <?php else:?>
                <p>No menu items found.</p>
            <?php endif;?>
        </div>
    </div>

    <div id="cart-sidebar" class="cart-sidebar">
    <div class="cart-sidebar-header">
        <h2>Cart</h2>
        <button id="close-cart-btn">&times;</button>
    </div>
    <div class="cart-items-container">
        <?php
        if (isset($_COOKIE['cart'])) {
            $cartItems = json_decode($_COOKIE['cart'], true);
            foreach ($cartItems as $item) {
                ?>
                <div class="cart-item">
                    <img src="<?= $item['image_url']?>" alt="<?= $item['name']?>">
                    <div class="cart-item-details">
                        <h3><?= $item['name']?></h3>
                        <p>₱<?= number_format($item['price'], 2)?></p>
                        <div class="cart-item-quantity">
                            <label>Quantity:</label>
                            <input type="number" value="<?= $item['quantity']?>" min="1">
                        </div>
                        <button class="btn btn-danger" data-id="<?= $item['id']?>">Remove</button>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p>Cart is empty.</p>';
        }
        ?>
    </div>
    <div class="cart-sidebar-footer">
        <p>Total: $<span id="cart-total">0</span></p>
        <button class="checkout-btn">Checkout</button>
    </div>
</div>

    <script src="menu.js"></script>
</body>
</html>

<?php $conn->close();?>