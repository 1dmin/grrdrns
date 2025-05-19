<?php
session_start();
require 'includes/db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

$user = $_SESSION['user'] ?? null;
$message = '';
$currentPage = basename($_SERVER['PHP_SELF']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service = $_POST['service'] ?? '';
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';

    if ($service && $date && $time) {
        try {
            $stmt = $pdo->prepare("INSERT INTO appointments (user_id, service, date, time) VALUES (:user_id, :service, :date, :time)");

            $user_id = isset($user['id']) ? $user['id'] : null;
            $stmt->execute([
                ':user_id' => $user_id,
                ':service' => $service,
                ':date' => $date,
                ':time' => $time
            ]);

            if ($user_id !== null) {
                try {
                    $reminderStmt = $pdo->prepare("INSERT INTO reminders (user_id, title, reminder_date, notes) VALUES (:user_id, :title, :reminder_date, :notes)");
                    $reminderStmt->execute([
                        ':user_id' => $user_id,
                        ':title' => ucfirst($service) . " Appointment",
                        ':reminder_date' => $date,
                        ':notes' => "Appointment at $time"
                    ]);
                    $message = "Appointment and reminder booked successfully!";
                } catch (PDOException $e) {
                    $message = "Appointment booked but reminder creation failed: " . $e->getMessage();
                }
            } else {
                $message = "Appointment booked successfully! (Please log in to receive reminders)";
            }
        } catch (PDOException $e) {
            $message = "Error booking appointment: " . $e->getMessage();
        }
    } else {
        $message = "Please fill in all fields.";
    }
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
      <a href="home.php">🏠 Home</a>
      <a href="adopt.php">❤️ Adopt</a>
      <a href="community.php">👥 Community</a>
      <a href="appointments.php" class="active">📅 Appointments</a>
      <a href="shop.php">🛒 Shop</a>
      <a href="notifications.php" title="Notifications">🔔</a>
      <a href="cart.php" title="View Cart">🛍️</a>

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

  <div class="ap-hero">
    <h1>Book an Appointment</h1>
    <p>Schedule a vet visit, grooming session, or pet training</p>
    <?php if ($message): ?>
      <p style="color: green; font-weight: bold;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
  </div>

  <section class="ap-appointment-form">
    <h2>Schedule an Appointment</h2>
    <form class="ap-appointment-form-content" method="post" action="appointments.php">
      <label for="service">Select Service:</label>
      <select name="service" class="ap-service" required>
        <option value="vet">Vet Visit</option>
        <option value="grooming">Grooming</option>
        <option value="training">Training</option>
      </select>

      <label for="date">Choose Date:</label>
      <input type="date" name="date" class="ap-date" required />

      <label for="time">Choose Time:</label>
      <input type="time" name="time" class="ap-time" required />

      <button type="submit" class="ap-submit-btn">Book Now</button>
    </form>
  </section>

  <section class="ap-upcoming-appointments">
    <h2>Your Upcoming Appointments</h2>
    <ul class="ap-appointment-list">
      <?php
      try {
          if ($user && isset($user['id'])) {
            $stmt = $pdo->prepare("SELECT service, date, time FROM appointments WHERE user_id = :user_id ORDER BY date, time");
            $stmt->execute([':user_id' => $user['id']]);
          } else {
              $stmt = $pdo->query("SELECT service, date, time FROM appointments ORDER BY date, time");
          }
          $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if ($appointments) {
              foreach ($appointments as $appt) {
                echo "<li class=\"ap-appointment-item\">📅 " . htmlspecialchars($appt['date']) . " at " . htmlspecialchars($appt['time']) . "</li>";

              }
          } else {
              echo '<li class="ap-no-appointments">No appointments scheduled.</li>';
          }
      } catch (PDOException $e) {
          echo '<li class="ap-no-appointments">Error fetching appointments.</li>';
      }
      ?>
    </ul>
  </section>
</body>
</html>
