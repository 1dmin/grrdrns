<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user']) || empty($_SESSION['user']['id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user']['id'];
$petId = $_GET['id'] ?? null;

if (!$petId) {
    header('Location: pet_records.php');
    exit;
}

// Optional: fetch pet to delete image file later
$stmt = $pdo->prepare("SELECT image_path FROM pets WHERE id = ? AND user_id = ?");
$stmt->execute([$petId, $userId]);
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pet) {
    echo "Pet not found or you don't have permission to delete this pet.";
    exit;
}

// Delete pet record
$stmt = $pdo->prepare("DELETE FROM pets WHERE id = ? AND user_id = ?");
$stmt->execute([$petId, $userId]);

// Optionally delete pet image file if exists
if ($pet['image_path'] && file_exists($pet['image_path'])) {
    unlink($pet['image_path']);
}

header('Location: pet_records.php');
exit;
?>
