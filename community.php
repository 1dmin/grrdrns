
<?php
require 'includes/db.php';

$stmt = $pdo->query("SELECT id, title, posted_by, replies FROM discussions ORDER BY created_at DESC");
$discussions = $stmt->fetchAll(PDO::FETCH_ASSOC);


session_start();
// Simulate user login info (replace with your actual auth system)
// e.g. ['name' => 'John Doe']    

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
if (!isset($_SESSION['user'])) {
  $_SESSION['user'] = ['name' => 'John Doe'];
}

$user = $_SESSION['user'] ?? null;
$currentPage = basename($_SERVER['PHP_SELF']);
// Simulated data from a database for discussions
$discussions = [
    ['id' => 'training', 'title' => 'How to train a stubborn puppy?', 'posted_by' => 'Alex', 'replies' => 5],
    ['id' => 'cat-food', 'title' => 'Best food brands for senior cats?', 'posted_by' => 'Lisa', 'replies' => 8],
];

// Simulated pet stories
$stories = [
    ['img' => 'dog_story.jpg', 'caption' => '"Max found his forever home! 🏡" - Sarah'],
    ['img' => 'cat_story.jpg', 'caption' => '"Milo\'s journey from rescue to happiness!" - Jason'],
];

// Simulated upcoming events
$events = [
    '🐕 Dog Training Workshop - April 15',
    '🐾 Pet Adoption Drive - May 3',
    '🏥 Free Vet Checkup - June 20',
];
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
  <a href="community.php" <?php if (in_array($currentPage, ['community.php', 'discussion.php'])) echo 'class="active"'; ?>>👥 Community</a>
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
      <?php var_dump($user); ?>
  <?php if ($user): ?>
    <span>Hello, <?php echo htmlspecialchars($user['name']); ?></span>
  <?php else: ?>
    <span>User not logged in</span>
  <?php endif; ?>
    </div>
  </div>
</nav>
  </header>

  <!-- Hero Section -->
  <section class="heroc">
    <h1>Welcome to the Pet Community 🐶🐱</h1>
    <p>Join discussions, share pet stories, and stay updated on upcoming pet events!</p>
    <a href="#" class="join-community-btn" onclick="joinCommunityc()">Join the Community</a>
  </section>

  <!-- Discussion Section -->
  <section class="discussion">
    <h2>Latest Discussions 🗨️</h2>
    <div class="discussion-list">
    <?php foreach ($discussions as $discussion): ?>
  <div class="discussion-item">
    <h3><?php echo htmlspecialchars($discussion['title']); ?></h3>
    <p>Posted by <?php echo htmlspecialchars($discussion['posted_by']); ?> - <?php echo (int)$discussion['replies']; ?> replies</p>
    <a href="discussion.php?topic=<?php echo urlencode($discussion['id']); ?>">Join Discussion</a>
  </div>
<?php endforeach; ?>

    </div>
  </section>

  <!-- User Stories Section -->
  <section class="user-stories">
    <h2>Featured Pet Stories ❤️</h2>
    <div class="story-grid">
      <?php foreach ($stories as $story): ?>
        <div class="story-card">
          <img src="<?php echo htmlspecialchars($story['img']); ?>" alt="Pet Story" />
          <p><?php echo htmlspecialchars($story['caption']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Upcoming Events -->
  <section class="events">
    <h2>Upcoming Pet Events 📅</h2>
    <ul>
      <?php foreach ($events as $event): ?>
        <li><?php echo htmlspecialchars($event); ?></li>
      <?php endforeach; ?>
    </ul>
  </section>

  <footer>
    <p>© 2025 PetConnect. All Rights Reserved.</p>
  </footer>

  <script>
    function joinCommunityc() {
      alert("Welcome! You've joined the PetConnect Community!");
    }
  </script>
</body>
</html>
