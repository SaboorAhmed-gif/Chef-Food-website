<?php 
include 'config.php';

if(!isLoggedIn()) {
  header("Location: login.php");
  exit;
}

if(isset($_POST['place_order'])) {
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $items = implode(',', $_SESSION['cart']);
  $total = getCartTotal($conn);
  $user_id = $_SESSION['user_id'];
  
  mysqli_query($conn, "INSERT INTO orders (user_id, items, total, address) VALUES ($user_id, '$items', $total, '$address')");
  $_SESSION['cart'] = [];
  header("Location: checkout.php?success=1");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - Chef's Food</title>
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
        <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
        <li class="nav-item"><a class="nav-link active" href="checkout.php">My Orders</a></li>
        <?php if(isAdmin()): ?><li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li><?php endif; ?>
        <li class="nav-item"><a class="nav-link" href="login.php?logout=1">Logout</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <h1 class="mb-4 fw-bold" style="color: #ff6b35;">My Orders</h1>
  
  <?php if(isset($_GET['success'])): ?>
  <div class="alert alert-success">Order placed successfully! We'll contact you soon.</div>
  <?php endif; ?>

  <?php if(!empty($_SESSION['cart'])): ?>
  <div class="card mb-4">
    <div class="card-body">
      <h4 class="fw-bold mb-3">Complete Your Order</h4>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label fw-bold">Delivery Address</label>
          <textarea name="address" class="form-control" rows="3" placeholder="Enter your complete address" required></textarea>
        </div>
        <h5 class="text-primary">Total: Rs <?php echo getCartTotal($conn); ?></h5>
        <button type="submit" name="place_order" class="btn btn-primary btn-lg">Place Order</button>
      </form>
    </div>
  </div>
  <?php endif; ?>

  <h3 class="fw-bold mb-3">Order History</h3>
  <?php
  $user_id = $_SESSION['user_id'];
  $orders = mysqli_query($conn, "SELECT * FROM orders WHERE user_id=$user_id ORDER BY id DESC");
  
  if(mysqli_num_rows($orders) == 0) {
    echo "<div class='alert alert-info'>No orders yet. Start ordering!</div>";
  } else {
    while($order = mysqli_fetch_assoc($orders)) {
      $status_class = "status-" . str_replace(' ', '\\', $order['status']);
      echo "<div class='card mb-3'>
        <div class='card-body'>
          <div class='d-flex justify-content-between mb-2'>
            <h5 class='fw-bold'>Order #{$order['id']}</h5>
            <span class='status-badge $status_class'>{$order['status']}</span>
          </div>
          <p class='text-muted mb-1'><strong>Date:</strong> {$order['created_at']}</p>
          <p class='text-muted mb-1'><strong>Address:</strong> {$order['address']}</p>
          <h5 class='text-primary fw-bold'>Total: Rs {$order['total']}</h5>
        </div>
      </div>";
    }
  }
  ?>
</div>

<footer class="bg-dark text-white text-center py-4 mt-5">
  <p class="mb-0">© 2026 Chef's Food</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
