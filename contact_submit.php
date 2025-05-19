<?php
// DB connection settings
$host = 'localhost';
$db   = 'crud';    // <- your DB name
$user = 'root';    // your DB user
$pass = '';        // your DB password (empty if none)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"] ?? ""));
    $email = filter_var(trim($_POST["email"] ?? ""), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"] ?? "");

    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Invalid input, redirect with error
        header("Location: contact.php?status=error");
        exit;
    }

    $sql = "INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':message' => $message
        ]);
        // Success, redirect with success status
        header("Location: contact.php?status=success");
        exit;
    } catch (PDOException $e) {
        // DB error, redirect with error
        header("Location: contact.php?status=error");
        exit;
    }
} else {
    // Direct access without POST: redirect to form
    header("Location: contact.php");
    exit;
}
?>
