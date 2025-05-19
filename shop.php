
<?php session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}?>

<?php if (!isset($_SESSION['user_id'])): ?>
  <div class="alert">⚠️ You must be logged in to add items to your cart or buy products.</div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Shop - PetConnect</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <header>
    <div class="logo">🐾 PetConnect</div>
    <nav>
      <a href="home.php">🏠 Home</a>
      <a href="adopt.php">❤️ Adopt</a>
      <a href="community.php">👥 Community</a>
      <a href="appointments.php">📅 Appointments</a>
      <a href="shop.php" class="active">🛒 Shop</a>
      <a href="notifications.php" title="Notifications">🔔</a>
      <a href="cart.php" title="View Cart">🛍️</a>
      <div class="dropdown">
        <button class="dropbtn">⚙️ Account ▼</button>
        <div class="dropdown-content">
          <a href="profile.php">Profile</a>
          <a href="pet_records.php">Manage Pets</a>
          <a href="reminders.php">Reminders</a>
          <a href="logout_confirmation.php">Logout</a>
        </div>
      </div>
    </nav>
  </header>

  <section class="shops-section">
    <div class="search-bar">
      <input type="text" placeholder="Search for pet products...">
    </div>

    <div class="products-slider">
      <?php
        $products = [
          ["id" => 1, "name" => "Premium Pet Food", "price" => 20.00, "image" => "food.jpg"],
          ["id" => 2, "name" => "Interactive Toy", "price" => 15.99, "image" => "toy.jpg"],
          ["id" => 3, "name" => "Grooming Kit", "price" => 30.00, "image" => "grooming.png"],
          ["id" => 4, "name" => "Cozy Pet Bed", "price" => 45.00, "image" => "bed.jpg"],
          ["id" => 5, "name" => "Durable Pet Leash", "price" => 20.00, "image" => "leash.jpg"],
          ["id" => 6, "name" => "Stainless Steel Bowl", "price" => 10.99, "image" => "bowl.jpg"],
          ["id" => 7, "name" => "Portable Pet Carrier", "price" => 55.99, "image" => "carrier.jpg"],
          ["id" => 8, "name" => "Natural Pet Shampoo", "price" => 12.99, "image" => "shampoo.jpg"],
          ["id" => 9, "name" => "Cat Scratcher", "price" => 28.50, "image" => "scratcher.jpg"],
          ["id" => 10, "name" => "Healthy Pet Treats", "price" => 9.99, "image" => "treats.jpg"]
        ];

        foreach ($products as $product):
      ?>
        <div class="products">
          <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
          <h3><?= htmlspecialchars($product['name']) ?></h3>
          <p>$<?= number_format($product['price'], 2) ?></p>
          <form method="POST" action="cart.php">
    <input type="hidden" name="action" value="add">
    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
    <input type="hidden" name="quantity" value="1">
    <button type="submit" class="cart-btns">Add to Cart</button>
</form>



          
        </div>
      <?php endforeach; ?>
    </div>
  </section>
  <script>
document.querySelectorAll(".cart-btns").forEach(button => {
    button.addEventListener("click", function() {
        this.closest("form").submit();
    });
});
</script>

</body>
</html>
