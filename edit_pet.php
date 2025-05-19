<?php
// start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'includes/db.php';

if (!isset($_SESSION['user']['id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user']['id'];
$petId = $_GET['id'] ?? null;

if (!$petId) {
    echo "Pet ID missing.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $breed = $_POST['breed'] ?? '';
    $type = $_POST['type'] ?? '';
    $age = $_POST['age'] ?? '';
    $birthdate = $_POST['birthdate'] ?? null;
    if (empty($birthdate)) {
        $birthdate = null;
    }
    $vaccination = $_POST['vaccination'] ?? '';
    $medical_history = $_POST['medical_history'] ?? '';
    $activity_log = $_POST['activity_log'] ?? '';

    if (!$name) {
        echo "Name is required.";
        exit;
    }

    $sql = "UPDATE pets SET 
                name = ?, 
                breed = ?, 
                type = ?, 
                age = ?, 
                birthdate = ?, 
                vaccination = ?, 
                medical_history = ?, 
                activity_log = ?
            WHERE id = ? AND user_id = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $name, 
        $breed, 
        $type, 
        $age, 
        $birthdate,  // this can be NULL now
        $vaccination, 
        $medical_history, 
        $activity_log, 
        $petId, 
        $userId
    ]);

    header("Location: pet_records.php");
    exit;
}

// Fetch pet data to prefill form if needed here...

?>


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Pet - PetConnect</title>
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

    <div class="petconnect-edit-pet-container">
        <h1>Edit Pet Record</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label>Name:<input type="text" name="name" value="<?= htmlspecialchars($pet['name']) ?>" required></label><br>
            <label>Breed:<input type="text" name="breed" value="<?= htmlspecialchars($pet['breed']) ?>"></label><br>
            <label>Type:<input type="text" name="type" value="<?= htmlspecialchars($pet['type']) ?>"></label><br>
            <label>Birthdate:<input type="date" name="birthdate" value="<?= htmlspecialchars($pet['birthdate']) ?>"></label><br>
            <label>Vaccination:<textarea name="vaccination"><?= htmlspecialchars($pet['vaccination']) ?></textarea></label><br>
            <label>Medical History:<textarea name="medical_history"><?= htmlspecialchars($pet['medical_history']) ?></textarea></label><br>
            <label>Activity Log:<textarea name="activity_log"><?= htmlspecialchars($pet['activity_log']) ?></textarea></label><br>
            <label>Current Image:<br>
                <?php if ($pet['image_path']): ?>
                    <img src="<?= htmlspecialchars($pet['image_path']) ?>" alt="Pet Image" style="max-width:150px;"><br>
                <?php else: ?>
                    No image uploaded.<br>
                <?php endif; ?>
            </label>
            <label>Upload New Image:<input type="file" name="image"></label><br>
            <button type="submit">Save Changes</button>
            <button type="button" onclick="window.location.href='pet_records.php'">Cancel</button>
        </form>
    </div>
</body>
</html>
