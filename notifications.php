<?php
session_start();

// Optional: Redirect if user not logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pet Reminders Calendar - PetConnect</title>
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
      <a href="notifications.php" title="Notifications">🔔</a>
      <a href="cart.php" title="View Cart">🛍️</a>
  
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

  <div class="notification-container">
    <h2>Reminders</h2>
    <div id="notifications-list"></div>
  </div>

  <script>
    function loadNotifications() {
      const reminderList = JSON.parse(localStorage.getItem('reminders') || '[]');
      const container = document.getElementById('notifications-list');

      if (reminderList.length === 0) {
        container.innerHTML = "<p>No upcoming reminders.</p>";
        return;
      }

      reminderList.forEach(reminder => {
        const div = document.createElement('div');
        div.className = 'notification';
        div.innerHTML = `
          <h3>${reminder.title}</h3>
          <p class="notification-date">📅 ${reminder.date}</p>
          <p>${reminder.notes || 'No additional notes.'}</p>
        `;
        container.appendChild(div);
      });
    }

    loadNotifications();
  </script>
</body>
</html>
    