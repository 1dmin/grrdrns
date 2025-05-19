<?php
session_start();
$user = $_SESSION['user'] ?? null;
$currentPage = basename($_SERVER['PHP_SELF']);

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pet Reminders Calendar - PetConnect</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <header>
    <div class="logo">🐾 PetConnect</div>
    <nav>
      <a href="home.php" <?php if ($currentPage == 'home.php') echo 'class="active"'; ?>>🏠 Home</a>
      <a href="adopt.php" <?php if ($currentPage == 'adopt.php') echo 'class="active"'; ?>>❤️ Adopt</a>
      <a href="community.php" <?php if ($currentPage == 'community.php') echo 'class="active"'; ?>>👥 Community</a>
      <a href="appointments.php" <?php if ($currentPage == 'appointments.php') echo 'class="active"'; ?>>📅 Appointments</a>
      <a href="shop.php" <?php if ($currentPage == 'shop.php') echo 'class="active"'; ?>>🛒 Shop</a>
      <a href="notifications.php" title="Notifications" <?php if ($currentPage == 'notifications.php') echo 'class="active"'; ?>>🔔</a>
      <a href="cart.php" title="View Cart" <?php if ($currentPage == 'cart.php') echo 'class="active"'; ?>>🛍️</a>
  
      <div class="dropdown">
        <button class="dropbtn">⚙️ Account ▼</button>
        <div class="dropdown-content">
          <?php if ($user): ?>
            <span style="padding: 0 12px; display:block; font-weight: bold;">Hello, <?php echo htmlspecialchars($user['name']); ?></span>
            <a href="profile.php">Profile</a>
            <a href="pet_records.php">Manage Pets</a>
            <a href="reminders.php">Reminders</a>
            <a href="logout.php">Logout</a>
          <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
          <?php endif; ?>
        </div>
      </div>
    </nav>
  </header>

  <section class="hero">
    <h1>Welcome to PetConnect</h1>
    <p>Find your perfect pet, book appointments, and connect with pet lovers.</p>
    <input type="text" placeholder="Search for pets, services, or products...">
    <button class="search-btn">🔍 Search</button>
  </section>

  <section class="adoption">
    <h2>🐶 Featured Pets for Adoption</h2>
    <div class="grid">
      <div class="pet-card">🐕 Buddy - Labrador, 2 years</div>
      <div class="pet-card">🐕 Luna - Beagle, 1 year</div>
      <div class="pet-card">🐕 Charlie - Poodle, 3 years</div>
    </div>
  </section>

  <section class="community">
    <h2>👥 Join Our Community</h2>
    <p>Connect with other pet lovers, share stories, and get expert advice.</p>
    <button class="cta-btn" onclick="window.location.href='community.php'">Join the Community</button>

  </section>

  <section class="appointments">
    <h2>📅 Book an Appointment</h2>
    <p>Schedule a visit with a vet, grooming, or training session.</p>
    <a href="appointments.php" class="cta-btn">Book Now</a>
  </section>

  <footer>
    <p>© 2025 PetConnect. All Rights Reserved.</p>
  </footer>
</body>
</html>
