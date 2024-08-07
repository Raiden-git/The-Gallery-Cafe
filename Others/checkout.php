<?php
session_start();
include 'Admin/db_connect.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_POST['action'];

switch ($action) {
    case 'add':
        // Existing code
        break;

    case 'update':
        // Existing code
        break;

    case 'remove':
        // Existing code
        break;

    case 'get':
        $total = array_reduce($_SESSION['cart'], function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        $response = [
            'cart' => $_SESSION['cart'],
            'total' => $total
        ];

        echo json_encode($response);
        break;
}

$conn->close();
?>
