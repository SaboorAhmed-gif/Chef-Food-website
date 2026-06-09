<?php
session_start();

// Error reporting for development - submit se pehle off kar dena
error_reporting(E_ALL);
ini_set('display_errors', 0); // 0 rakho taake user ko error na dikhe

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'chef_food');

// Create connection with error handling
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to UTF-8 for Urdu/English support
mysqli_set_charset($conn, "utf8mb4");

// Cart session initialize
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Helper Functions
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin';
}

function getCartCount() {
    return isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
}

function getCartTotal($conn) {
    $total = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $id) {
            $result = mysqli_query($conn, "SELECT price FROM menu WHERE id=$id");
            if ($row = mysqli_fetch_assoc($result)) {
                $total += $row['price'];
            }
        }
    }
    return $total;
}

// Sanitize input to prevent SQL injection
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}
?>
