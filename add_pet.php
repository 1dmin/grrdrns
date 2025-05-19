<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user']) || empty($_SESSION['user']['id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $breed = $_POST['breed'] ?? '';
    $type = $_POST['type'] ?? '';
    $birthdate = $_POST['birthdate'] ?? null;
    $vaccination = $_POST['vaccination'] ?? '';
    $medical_history = $_POST['medical_history'] ?? '';
    $activity_log = $_POST['activity_log'] ?? '';
    $image_path = null;

    // Handle image upload if any
    if (!empty($_FILES['image']['name'])) {
        $targetDir = 'uploads/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $targetFile = $targetDir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image_path = $targetFile;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO pets (user_id, name, breed, type, birthdate, vaccination, medical_history, activity_log, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$userId, $name, $breed, $type, $birthdate, $vaccination, $medical_history, $activity_log, $image_path]);

    header('Location: pet_records.php');
    exit;
}
?>
