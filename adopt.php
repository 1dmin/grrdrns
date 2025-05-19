
<?php
 
 
require 'includes/db.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM pets WHERE name LIKE ?");
    $stmt->execute(["%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM pets");
}

$pets = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $petName = $_POST['petName'];
    $yourName = $_POST['yourName'];
    $email = $_POST['email'];
    $reason = $_POST['reason'];

    $stmt = $pdo->prepare("INSERT INTO adoption_requests (pet_name, adopter_name, email, reason) VALUES (?, ?, ?, ?)");
    $stmt->execute([$petName, $yourName, $email, $reason]);

    echo "<script>alert('Thank you! Your adoption request has been submitted.');</script>";

   
  }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pet Adoption - PetConnect</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <header>
    <div class="logo">🐾 PetConnect</div>
    <nav>
      <a href="home.php">🏠 Home</a>
      <a href="adopt.php" class="active">❤️ Adopt</a>
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

  
<section class="heroa">
  <h1>Find Your New Best Friend</h1>
  <p>Search for adoptable pets near you</p>
  <form method="GET" action="adopt.php">
  <input type="text" name="search" placeholder="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
  </button>
</form>
</section>

  <section class="adoption-grid">
  <?php if ($pets): ?>
    <?php foreach ($pets as $pet): ?>
      <div class="pet-carda">
        <img src="<?php echo htmlspecialchars($pet['image_path'] ?? 'default.jpg'); ?>" alt="Adoptable Pet">
        <h3><?php echo htmlspecialchars($pet['name']); ?></h3>
        <p>Breed: <?php echo htmlspecialchars($pet['breed']); ?></p>
        <p>Age: <?php echo htmlspecialchars($pet['age']); ?></p>
        <button onclick="openAdoptionForm('<?php echo htmlspecialchars($pet['name']); ?>')">Adopt Me</button>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>No pets found matching your search.</p>
  <?php endif; ?>
</section>


  <div id="adoptionModal" class="modal" style="display:none;">
    <div class="modal-content">
      <span class="close" onclick="closeAdoptionForm()">&times;</span>
      <h2>Adoption Application</h2>
      <form method="POST" id="adoptionForm">
        <label for="petName">Pet Name</label>
        <input type="text" id="petName" name="petName" readonly>

        <label for="yourName">Your Full Name</label>
        <input type="text" name="yourName" required>

        <label for="email">Email Address</label>
        <input type="email" name="email" required>

        <label for="reason">Why do you want to adopt this pet?</label>
        <textarea name="reason" required></textarea>

        <button type="submit">Submit Application</button>
      </form>
    </div>
  </div>

  <footer>
    <p>© 2025 PetConnect. All Rights Reserved.</p>
  </footer>

  <script>
    function openAdoptionForm(petName) {
      document.getElementById('petName').value = petName;
      document.getElementById('adoptionModal').style.display = 'block';
    }

    function closeAdoptionForm() {
      document.getElementById('adoptionModal').style.display = 'none';
    }

    window.onclick = function(event) {
      const modal = document.getElementById('adoptionModal');
      if (event.target === modal) {
        closeAdoptionForm();
      }
    }
  </script>
</body>
</html>
