<?php
// add_to_cart.php

// Assume you have a function to add the item to the cart
function addToCart($itemId, $quantity) {
    // Add the item to the cart array
    $_SESSION['cart'][$itemId] = array(
        'id' => $itemId,
        'quantity' => $quantity,
        // Add other item details as needed
    );

    // Set the cookie
    setcookie('cart', json_encode($_SESSION['cart']), time() + 86400); // expires in 1 day

    // Return a success message or redirect to the cart page
    echo 'Item added to cart successfully!';
    exit;
}

// Call the function when the "Add to Cart" button is clicked
if (isset($_POST['add_to_cart'])) {
    $itemId = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    addToCart($itemId, $quantity);
}