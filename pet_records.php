<?php
session_start();
require 'includes/db.php';
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

// Redirect to login if not logged in

$userId = $_SESSION['user']['id'];

// Fetch pets for this user
$user_id = 1; // Replace with actual logged-in user ID from session
$stmt = $pdo->prepare("SELECT * FROM pets WHERE user_id = ?");
$stmt->execute([$user_id]);
$pets = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Pet Records - PetConnect</title>
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

  <div class="petconnect-pet-records-container">
    <h1>Manage Pet Records</h1>
    <button onclick="document.getElementById('addPetForm').style.display='block'">+ Add New Pet</button>

    <div class="petconnect-pet-record-grid">
      <?php foreach ($pets as $pet): ?>
        <div class="petconnect-pet-record-card">
          <img src="<?= htmlspecialchars($pet['image_path'] ?: 'https://via.placeholder.com/120') ?>" alt="Pet <?= htmlspecialchars($pet['name']) ?>" class="petconnect-pet-img" />
          <p><strong>Pet Name:</strong> <?= htmlspecialchars($pet['name']) ?></p>
          <p><strong>Breed:</strong> <?= htmlspecialchars($pet['breed']) ?></p>
          <p><strong>Type:</strong> <?= htmlspecialchars($pet['type']) ?></p>
          <p><strong>Birthdate:</strong> <?= htmlspecialchars($pet['birthdate']) ?></p>
          <div>
            <h3>Vaccination Records</h3>
            <pre><?= htmlspecialchars($pet['vaccination']) ?></pre>
          </div>
          <div>
            <h3>Medical History</h3>
            <pre><?= htmlspecialchars($pet['medical_history']) ?></pre>
          </div>
          <div>
            <h3>Activity Log</h3>
            <pre><?= htmlspecialchars($pet['activity_log']) ?></pre>
          </div>
          <button onclick="window.location.href='edit_pet.php?id=<?= $pet['id'] ?>'">Edit Records</button>
<button onclick="if(confirm('Are you sure you want to delete this pet?')) { window.location.href='delete_pet.php?id=<?= $pet['id'] ?>' }">Delete Pet</button>

        </div>
      <?php endforeach; ?>
    </div>

    <!-- Add Pet Form -->
    <div id="addPetForm" style="display:none;">
      <h2>Add New Pet</h2>
      <form action="add_pet.php" method="POST" enctype="multipart/form-data">
        <label>Name:<input type="text" name="name" required></label><br>
        <label>Breed:<input type="text" name="breed"></label><br>
        <label>Type:<input type="text" name="type"></label><br>
        <label>Birthdate:<input type="date" name="birthdate"></label><br>
        <label>Vaccination:<textarea name="vaccination"></textarea></label><br>
        <label>Medical History:<textarea name="medical_history"></textarea></label><br>
        <label>Activity Log:<textarea name="activity_log"></textarea></label><br>
        <label>Image:<input type="file" name="image"></label><br>
        <button type="submit">Save Pet</button>
        <button type="button" onclick="document.getElementById('addPetForm').style.display='none'">Cancel</button>
        
      </form>
    </div>

  </div>
</body>
</html>
