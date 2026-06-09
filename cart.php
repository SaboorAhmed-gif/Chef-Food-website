<?php 
include 'config.php';

if(isset($_GET['add'])) {
  $id = $_GET['add'];
  $_SESSION['cart'][] = $id;
  header("Location: cart.php?added=1");
}

if(isset($_GET['remove'])) {
  $id = $_GET['remove'];
  $key = array_search($id, $_SESSION['cart']);
  if($key !== false) unset($_SESSION['cart'][$key]);
  header("Location: cart.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart - Chef's Food</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🍛 Chef's Food</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
        <li class="nav-item"><a class="nav-link active" href="cart.php">Cart</a></li>
        <?php if(isLoggedIn()): ?>
          <li class="nav-item"><a class="nav-link" href="checkout.php">My Orders</a></li>
          <?php if(isAdmin()): ?><li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li><?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="login.php?logout=1">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <h1 class="mb-4 fw-bold" style="color: #ff6b35;">Your Cart 🛒</h1>
  
  <?php if(isset($_GET['added'])): ?>
  <div class="alert alert-success">Item added to cart successfully!</div>
  <?php endif; ?>

  <?php if(empty($_SESSION['cart'])): ?>
    <div class="alert alert-info text-center py-5">
      <h4>Your cart is empty</h4>
      <a href="menu.php" class="btn btn-primary mt-3">Browse Menu</a>
    </div>
  <?php else: ?>
    <div class="row">
      <div class="col-md-8">
        <?php
        $total = 0;
        foreach($_SESSION['cart'] as $id) {
          $item = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM menu WHERE id=$id"));
          $total += $item['price'];
          echo "<div class='card mb-3'>
            <div class='row g-0'>
              <div class='col-md-3'>
                <img src='{$item['image']}' class='img-fluid rounded-start h-100' style='object-fit:cover'>
              </div>
              <div class='col-md-9'>
                <div class='card-body'>
                  <h5 class='card-title fw-bold'>{$item['name']}</h5>
                  <p class='card-text text-muted'>{$item['description']}</p>
                  <div class='d-flex justify-content-between align-items-center'>
                    <h4 class='text-primary fw-bold mb-0'>Rs {$item['price']}</h4>
                    <a href='cart.php?remove={$item['id']}' class='btn btn-danger btn-sm'>Remove</a>
                  </div>
                </div>
              </div>
            </div>
          </div>";
        }
        ?>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h4 class="fw-bold mb-3">Order Summary</h4>
            <div class="d-flex justify-content-between mb-2">
              <span>Subtotal:</span>
              <span class="fw-bold">Rs <?php echo $total; ?></span>
            </div>
            <div class="d-flex justify-content-between mb-3">
              <span>Delivery:</span>
              <span class="fw-bold text-success">FREE</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-3">
              <h5>Total:</h5>
              <h5 class="text-primary fw-bold">Rs <?php echo $total; ?></h5>
            </div>
            <a href="checkout.php" class="btn btn-primary w-100 btn-lg">Proceed to Checkout</a>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<footer class="bg-dark text-white text-center py-4 mt-5">
  <p class="mb-0">© 2026 Chef's Food</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
