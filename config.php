<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "chef_food");
if(!$conn) die("DB Connection Error");

function isLoggedIn() { return isset($_SESSION['user_id']); }
function isAdmin() { return isset($_SESSION['role']) && $_SESSION['role']=='admin'; }

function getCartTotal($conn) {
  $total = 0;
  if(isset($_SESSION['cart'])) {
    foreach($_SESSION['cart'] as $id) {
      $item = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM menu WHERE id=$id"));
      $total += $item['price'];
    }
  }
  return $total;
}
?>
