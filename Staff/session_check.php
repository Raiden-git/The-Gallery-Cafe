<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.html');
    exit;
}

?>