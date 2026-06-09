<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - Chef's Food</title>
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
        <?php if(isLoggedIn()): ?>
          <li class="nav-item"><a class="nav-link" href="checkout.php">My Orders</a></li>
          <?php if(isAdmin()): ?><li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li><?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="login.php?logout=1">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link active" href="about.php">About</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="hero text-white text-center" style="min-height: 300px;">
  <div class="container">
    <h1 class="display-4 fw-bold">About Chef's Food</h1>
  </div>
</div>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-6">
      <h2 class="fw-bold mb-3" style="color: #ff6b35;">Our Story</h2>
      <p class="lead">Chef's Food started in 2020 with one mission: bring authentic Pakistani flavors to your doorstep.</p>
      <p>We use only the freshest ingredients and traditional recipes passed down through generations. Every dish is prepared with love by our experienced chefs.</p>
    </div>
    <div class="col-md-6">
      <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=600" class="img-fluid rounded-4 shadow">
    </div>
  </div>
  
  <div class="row mt-5 text-center">
    <div class="col-md-4">
      <h3 class="fw-bold" style="color: #ff6b35;">1000+</h3>
      <p>Happy Customers</p>
    </div>
    <div class="col-md-4">
      <h3 class="fw-bold" style="color: #ff6b35;">50+</h3>
      <p>Authentic Dishes</p>
    </div>
    <div class="col-md-4">
      <h3 class="fw-bold" style="color: #ff6b35;">24/7</h3>
      <p>Service Available</p>
    </div>
  </div>
</div>

<footer class="bg-dark text-white text-center py-4 mt-5">
  <p class="mb-0">© 2026 Chef's Food | Contact: 0300-1234567</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
