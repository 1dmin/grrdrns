<?php
session_start();
require 'includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Get user data from session once
$user = $_SESSION['user'] ?? null;

if (!$user) {
    header('Location: login.php');
    exit;
}

// Ensure user id exists in session data
$userId = $user['id'] ?? null;


$reminders = [];
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $title = trim($_POST['title'] ?? '');
    $date = $_POST['date'] ?? '';
    $notes = trim($_POST['notes'] ?? '');

    if ($title && $date) {
        try {
            // Debug information
            error_log("Attempting to add reminder - Title: $title, Date: $date, Notes: $notes, User ID: $userId");
            
            $stmt = $pdo->prepare("INSERT INTO reminders (user_id, title, reminder_date, notes) VALUES (:user_id, :title, :date, :notes)");
            $stmt->execute([
                ':user_id' => $userId,
                ':title' => $title,
                ':date' => $date,
                ':notes' => $notes,
            ]);
            
            // Check if the insert was successful
            if ($stmt->rowCount() > 0) {
                $message = "Reminder added successfully!";
                error_log("Reminder added successfully");
            } else {
                $error = "Failed to add reminder - no rows affected";
                error_log("Failed to add reminder - no rows affected");
            }
        } catch (PDOException $e) {
            $error = "Error saving reminder: " . $e->getMessage();
            error_log("Database error: " . $e->getMessage());
        }
    } else {
        $error = "Title and date are required.";
        error_log("Validation failed - Title: $title, Date: $date");
    }
}

// Load reminders for the user
try {
    error_log("Loading reminders for user ID: $userId");
    $stmt = $pdo->prepare("SELECT title, reminder_date as date, notes FROM reminders WHERE user_id = :user_id ORDER BY reminder_date");
    $stmt->execute([':user_id' => $userId]);
    $reminders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Found " . count($reminders) . " reminders");
} catch (PDOException $e) {
    $reminders = [];
    $error = "Error loading reminders: " . $e->getMessage();
    error_log("Error loading reminders: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pet Reminders Calendar - PetConnect</title>
  <link rel="stylesheet" href="styles.css" />
  <style>
    .notification { padding: 10px; margin: 10px 0; border-radius: 5px; }
    .success { background-color: #d4edda; color: #155724; }
    .error { background-color: #f8d7da; color: #721c24; }
    .reminder-item { border: 1px solid #ccc; padding: 10px; margin-bottom: 8px; border-radius: 4px; }
    .today { background-color: #ffecb3; }
  </style>
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
        <a href="reminders.php" class="active">Reminders</a>
        <a href="#">Logout</a>
      </div>
    </div>
  </nav>
</header>

<div class="reminder-container" style="display: flex; gap: 20px; padding: 20px;">
  <div class="calendar" style="flex:1;">
    <h2 id="calendar-month-year">Calendar</h2>
    <table id="calendar-table" border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse: collapse;">
      <thead>
        <tr>
          <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
        </tr>
      </thead>
      <tbody id="calendar-body"></tbody>
    </table>
  </div>

  <div class="form-area" style="flex:1;">
    <h1>Pet Reminders</h1>

    <?php if ($message): ?>
      <div class="notification success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="notification error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form id="reminder-form" method="POST" action="reminders.php" onsubmit="return validateForm()">
      <input type="text" name="title" placeholder="Reminder Title" required style="width: 100%; margin-bottom: 10px;" />
      <input type="date" name="date" required style="width: 100%; margin-bottom: 10px;" />
      <textarea name="notes" rows="3" placeholder="Additional Notes" style="width: 100%; margin-bottom: 10px;"></textarea>
      <button type="submit" style="padding: 10px 20px;">Add Reminder</button>
    </form>

    <div class="reminder-list" style="margin-top: 20px;">
      <?php if (!empty($reminders)): ?>
        <?php foreach ($reminders as $r): ?>
          <div class="reminder-item">
            <h3><?= htmlspecialchars($r['title']) ?></h3>
            <p><strong>Date:</strong> <?= htmlspecialchars($r['date']) ?></p>
            <?php if (!empty($r['notes'])): ?>
              <p><?= nl2br(htmlspecialchars($r['notes'])) ?></p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No reminders yet.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  function generateCalendar() {
    const calendarBody = document.getElementById('calendar-body');
    const monthYearLabel = document.getElementById('calendar-month-year');

    const date = new Date();
    const year = date.getFullYear();
    const month = date.getMonth();
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    const monthNames = [
      'January', 'February', 'March', 'April', 'May', 'June',
      'July', 'August', 'September', 'October', 'November', 'December'
    ];

    monthYearLabel.textContent = `${monthNames[month]} ${year}`;

    calendarBody.innerHTML = '';
    let row = document.createElement('tr');

    for (let i = 0; i < firstDay; i++) {
      const emptyCell = document.createElement('td');
      row.appendChild(emptyCell);
    }

    for (let day = 1; day <= daysInMonth; day++) {
      const cell = document.createElement('td');
      cell.textContent = day;

      const today = new Date();
      if (
        day === today.getDate() &&
        month === today.getMonth() &&
        year === today.getFullYear()
      ) {
        cell.classList.add('today');
      }

      row.appendChild(cell);
      if ((firstDay + day) % 7 === 0 || day === daysInMonth) {
        calendarBody.appendChild(row);
        row = document.createElement('tr');
      }
    }
  }

  generateCalendar();

  function validateForm() {
    const title = document.querySelector('input[name="title"]').value;
    const date = document.querySelector('input[name="date"]').value;
    
    if (!title || !date) {
      alert('Please fill in both title and date fields');
      return false;
    }
    
    return true;
  }

  // Function to add a new reminder to the list
  function addReminderToList(reminder) {
    const reminderList = document.querySelector('.reminder-list');
    const noReminders = reminderList.querySelector('p');
    
    if (noReminders && noReminders.textContent === 'No reminders yet.') {
      reminderList.innerHTML = '';
    }

    const reminderItem = document.createElement('div');
    reminderItem.className = 'reminder-item';
    reminderItem.innerHTML = `
      <h3>${reminder.title}</h3>
      <p><strong>Date:</strong> ${reminder.date}</p>
      ${reminder.notes ? `<p>${reminder.notes}</p>` : ''}
    `;
    
    reminderList.insertBefore(reminderItem, reminderList.firstChild);
  }

  // Handle form submission
  document.getElementById('reminder-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = {
      title: formData.get('title'),
      date: formData.get('date'),
      notes: formData.get('notes')
    };

    // Send the reminder data to the server
    fetch('reminders.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: new URLSearchParams(formData)
    })
    .then(response => response.text())
    .then(html => {
      // Add the new reminder to the list
      addReminderToList(data);
      
      // Clear the form
      this.reset();
      
      // Show success message
      const messageDiv = document.createElement('div');
      messageDiv.className = 'notification success';
      messageDiv.textContent = 'Reminder added successfully!';
      this.parentNode.insertBefore(messageDiv, this);
      
      // Remove the success message after 3 seconds
      setTimeout(() => {
        messageDiv.remove();
      }, 3000);
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Error adding reminder. Please try again.');
    });
  });
</script>

</body>
</html>
