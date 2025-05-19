<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
// Simulated discussions data with posts
$discussions = [
    'training' => [
        'title' => 'How to train a stubborn puppy?',
        'posts' => [
            ['author' => 'Alex', 'content' => 'Start with positive reinforcement and consistency!'],
            ['author' => 'Jamie', 'content' => 'Patience is key. Avoid punishment.'],
        ],
    ],
    'cat-food' => [
        'title' => 'Best food brands for senior cats?',
        'posts' => [
            ['author' => 'Lisa', 'content' => 'Look for high protein and low carbs.'],
            ['author' => 'Mia', 'content' => 'I recommend brand X for its natural ingredients.'],
        ],
    ],
];

// Get the topic from the URL
$topic = $_GET['topic'] ?? '';

if (!array_key_exists($topic, $discussions)) {
    $error = "Sorry, discussion topic not found.";
} else {
    $discussion = $discussions[$topic];
}

// Handle new comment submission (demo only)
$newCommentMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $author = trim($_POST['author'] ?? '');
    $comment = trim($_POST['comment'] ?? '');

    if ($author && $comment) {
        // In a real app, save to DB here. For demo, just append to posts array temporarily.
        $discussions[$topic]['posts'][] = ['author' => $author, 'content' => $comment];
        $newCommentMsg = "Thanks for your comment, " . htmlspecialchars($author) . "!";
    } else {
        $newCommentMsg = "Please fill in all fields to submit a comment.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $topic ? htmlspecialchars($discussion['title']) : 'Discussion Not Found'; ?> - PetConnect</title>
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
      <a href="profile.php">Profile</a>
      <a href="pet_records.php">Manage Pets</a>
      <a href="reminders.php">Reminders</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>
</nav>

</header>

<main style="max-width: 800px; margin: 20px auto; padding: 0 20px;">
    <?php if (isset($error)): ?>
        <h2>Error</h2>
        <p><?php echo htmlspecialchars($error); ?></p>
        <p><a href="community.php">Back to Community</a></p>
    <?php else: ?>
        <h1><?php echo htmlspecialchars($discussion['title']); ?></h1>

        <section class="posts">
            <?php foreach ($discussions[$topic]['posts'] as $post): ?>
                <div class="post" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                    <strong><?php echo htmlspecialchars($post['author']); ?> says:</strong>
                    <p><?php echo htmlspecialchars($post['content']); ?></p>
                </div>
            <?php endforeach; ?>
        </section>

        <section class="add-comment" style="margin-top: 40px;">
            <h2>Add a Comment</h2>
            <?php if ($newCommentMsg): ?>
                <p style="color: green;"><?php echo htmlspecialchars($newCommentMsg); ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <label for="author">Your Name:</label><br />
                <input type="text" id="author" name="author" required style="width: 100%; max-width: 300px; margin-bottom: 10px;" /><br />

                <label for="comment">Comment:</label><br />
                <textarea id="comment" name="comment" required rows="4" style="width: 100%; max-width: 500px; margin-bottom: 10px;"></textarea><br />

                <button type="submit">Submit Comment</button>
            </form>
        </section>

        <p><a href="community.php" style="display: inline-block; margin-top: 20px;">← Back to Community</a></p>
    <?php endif; ?>
</main>

<footer style="text-align:center; margin-top: 40px;">
    <p>© 2025 PetConnect. All Rights Reserved.</p>
</footer>

</body>
</html>
