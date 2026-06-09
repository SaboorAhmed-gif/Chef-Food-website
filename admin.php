<?php 
include 'config.php';

if(!isAdmin()) {
  header("Location: login.php");
  exit;
}

if(isset($_GET['update_status'])) {
  $id = $_GET['id'];
  $status = $_GET['status'];
  mysqli_query($conn, "UPDATE orders SET status='$status' WHERE id=$id");
  header("Location: admin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Chef's Food</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🍛 Chef's Food Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="admin.php">Admin</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php?logout=1">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <h1 class="mb-4 fw-bold" style="color: #ff6b35;">Admin Dashboard</h1>
  
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card text-white bg-primary">
        <div class="card-body">
          <h5>Total Orders</h5>
          <h2><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT id FROM orders")); ?></h2>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-success">
        <div class="card-body">
          <h5>Total Users</h5>
          <h2><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE role='user'")); ?></h2>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-warning">
        <div class="card-body">
          <h5>Menu Items</h5>
          <h2><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT id FROM menu")); ?></h2>
        </div>
      </div>
    </div>
  </div>

  <h3 class="fw-bold mb-3">Manage Orders</h3>
  <?php
  $orders = mysqli_query($conn, "SELECT o.*, u.name FROM orders o JOIN users u ON o.user_id=u.id ORDER BY o.id DESC");
  while($order = mysqli_fetch_assoc($orders)) {
    $status_class = "status-" . str_replace(' ', '\\', $order['status']);
    echo "<div class='card mb-3'>
      <div class='card-body'>
        <div class='row'>
          <div class='col-md-8'>
            <h5 class='fw-bold'>Order #{$order['id']} - {$order['name']}</h5>
            <p class='mb-1'><strong>Date:</strong> {$order['created_at']}</p>
            <p class='mb-1'><strong>Address:</strong> {$order['address']}</p>
            <h5 class='text-primary'>Total: Rs {$order['total']}</h5>
          </div>
          <div class='col-md-4 text-end'>
            <span class='status-badge $status_class d-block mb-2'>{$order['status']}</span>
            <div class='btn-group'>
              <a href='admin.php?update_status=1&id={$order['id']}&status=Preparing' class='btn btn-sm btn-warning'>Preparing</a>
              <a href='admin.php?update_status=1&id={$order['id']}&status=Out for Delivery' class='btn btn-sm btn-info'>Delivery</a>
              <a href='admin.php?update_status=1&id={$order['id']}&status=Delivered' class='btn btn-sm btn-success'>Delivered</a>
            </div>
          </div>
        </div>
      </div>
    </div>";
  }
  ?>
</div>

<footer class="bg-dark text-white text-center py-4 mt-5">
  <p class="mb-0">© 2026 Chef's Food Admin</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
