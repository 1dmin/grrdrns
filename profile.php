<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
// Redirect to login if not logged in

// For now, get user info from session
$user = $_SESSION['user'];

// Example default values if not set
$name = $user['name'] ?? 'No Name Set';
$email = $user['email'] ?? 'No Email Set';
$location = $user['location'] ?? 'Unknown';
$phone = $user['phone'] ?? 'Not Provided';
$memberSince = $user['member_since'] ?? 'January 2024'; // You might want to get this from DB

?>
<!DOCTYPE html>
<html lang="en">  
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My Profile - PetConnect</title>
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

  <div class="profile-container">
    <h1>My Profile</h1>
    <div class="profile-card">
      <img src="profile.jpg" alt="Profile Picture" class="profile-pic" />
      <p><strong>Name:</strong> <span id="profile-name"><?= htmlspecialchars($name) ?></span></p>
      <p><strong>Email:</strong> <span id="profile-email"><?= htmlspecialchars($email) ?></span></p>
      <p><strong>Location:</strong> <span id="profile-location"><?= htmlspecialchars($location) ?></span></p>
      <p><strong>Phone:</strong> <span id="profile-phone"><?= htmlspecialchars($phone) ?></span></p>
      <p><strong>Member Since:</strong> <span id="profile-member-since"><?= htmlspecialchars($memberSince) ?></span></p>
      <a href="edit_profile.php" class="pc-edit-btn">Edit Profile</a>
    </div>
  </div>

  <script>
    // If you want to load profile data from localStorage as fallback
    function loadProfileData() {
      const profileData = JSON.parse(localStorage.getItem('profileData'));
      if (profileData) {
        document.getElementById('profile-name').innerText = profileData.name;
        document.getElementById('profile-email').innerText = profileData.email;
        document.getElementById('profile-location').innerText = profileData.location;
        document.getElementById('profile-phone').innerText = profileData.phone;
      }
    }

    window.onload = function() {
      loadProfileData();
    };
  </script>
</body>
</html>
