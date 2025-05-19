<?php
session_start();
require 'includes/db.php'; // Optional, if you want to use DB
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
// Check if user is logged in

$userId = $_SESSION['user']['id'];

// Example: Load existing user data from session or DB
// Here, from session for demo:
$name = $_SESSION['user']['name'] ?? '';
$email = $_SESSION['user']['email'] ?? '';
$location = $_SESSION['user']['location'] ?? '';
$phone = $_SESSION['user']['phone'] ?? '';
$memberSince = 'January 2024'; // Or load from DB

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data safely
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $location = trim($_POST['location']);
    $phone = trim($_POST['phone']);
    
    // TODO: Add validation here
    
    // TODO: Update user data in DB, example:
    /*
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, location = ?, phone = ? WHERE id = ?");
    $stmt->execute([$name, $email, $location, $phone, $userId]);
    */
    
    // Update session data
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['location'] = $location;
    $_SESSION['user']['phone'] = $phone;
    
    // Redirect to profile page after saving
    header('Location: profile.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Profile - PetConnect</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
<header>
    <div class="logo">🐾 PetConnect</div>
    <nav>
        <a href="Home.php">🏠 Home</a>
        <a href="adopt.php">❤️ Adopt</a>
        <a href="community.php">👥 Community</a>
        <a href="appointments.php">📅 Appointments</a>
        <a href="shop.php">🛒 Shop</a>
        <div class="dropdown">
            <button class="dropbtn">⚙️ Account ▼</button>
            <div class="dropdown-content">
                <a href="profile.php">Profile</a>
                <a href="pet_records.php">Manage Pets</a>
                <a href="reminders.php">Reminders</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>
</header>

<div class="pc-profile-container">
    <h1>Edit Profile</h1>
    <form id="editProfileForm" class="pc-edit-profile-form" method="POST" action="">
        <div class="pc-form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required value="<?= htmlspecialchars($name) ?>" />
        </div>

        <div class="pc-form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required value="<?= htmlspecialchars($email) ?>" />
        </div>

        <div class="pc-form-group">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required value="<?= htmlspecialchars($location) ?>" />
        </div>

        <div class="pc-form-group">
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required value="<?= htmlspecialchars($phone) ?>" />
        </div>

        <div class="pc-form-group">
            <label for="member-since">Member Since:</label>
            <input type="text" id="member-since" name="member-since" value="<?= htmlspecialchars($memberSince) ?>" disabled />
        </div>

        <div class="pc-form-actions">
            <button type="submit" class="pc-profile-btn">Save Changes</button>
            <button type="button" class="pc-cancel-btn" onclick="window.location.href='profile.php'">Cancel</button>
        </div>
    </form>
</div>
</body>
</html>
