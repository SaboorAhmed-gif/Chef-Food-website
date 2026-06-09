<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu - Chef's Food</title>
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
        <li class="nav-item"><a class="nav-link active" href="menu.php">Menu</a></li>
        <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
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
  <h1 class="text-center mb-5 fw-bold" style="color: #ff6b35;">Our Complete Menu</h1>
  
  <?php
  $categories = ['Biryani', 'Karahi', 'BBQ', 'Bread', 'Sides'];
  foreach($categories as $cat) {
    $result = mysqli_query($conn, "SELECT * FROM menu WHERE category='$cat'");
    if(mysqli_num_rows($result) > 0) {
      echo "<h3 class='category-title'>$cat</h3><div class='row g-4 mb-5'>";
      while($row = mysqli_fetch_assoc($result)) {
        $badge = $row['is_special'] ? "<span class='special-badge position-absolute m-3'>Chef's Special</span>" : "";
        echo "<div class='col-md-4'>
          <div class='card h-100'>
            $badge
            <img src='{$row['image']}' class='card-img-top' style='height:250px;object-fit:cover'>
            <div class='card-body d-flex flex-column'>
              <h5 class='card-title fw-bold'>{$row['name']}</h5>
              <p class='card-text text-muted flex-grow-1'>{$row['description']}</p>
              <div class='mt-auto'>
                <h4 class='text-primary fw-bold'>Rs {$row['price']}</h4>
                <a href='cart.php?add={$row['id']}' class='btn btn-primary w-100'>Add to Cart</a>
              </div>
            </div>
          </div>
        </div>";
      }
      echo "</div>";
    }
  }
  ?>
</div>

<footer class="bg-dark text-white text-center py-4">
  <p class="mb-0">© 2026 Chef's Food. All Rights Reserved</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
