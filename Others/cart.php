<?php
session_start();
include 'Admin/db_connect.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_POST['action'];

switch ($action) {
    case 'add':
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $image = $_POST['image'];

        $exists = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $item['quantity'] += $quantity;
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            $_SESSION['cart'][] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'image' => $image
            ];
        }
        break;

    case 'update':
        $id = $_POST['id'];
        $quantity = $_POST['quantity'];

        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $item['quantity'] = $quantity;
                break;
            }
        }
        break;

    case 'remove':
        $id = $_POST['id'];

        $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($id) {
            return $item['id'] != $id;
        });
        break;
}

$total = array_reduce($_SESSION['cart'], function ($sum, $item) {
    return $sum + ($item['price'] * $item['quantity']);
}, 0);

$response = [
    'cart' => $_SESSION['cart'],
    'total' => $total
];

echo json_encode($response);

$conn->close();
?>