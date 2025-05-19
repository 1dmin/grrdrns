<?php
session_start();
require 'includes/db.php';
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad(); // Don't crash if .env is missing

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recaptchaSecret = $_ENV['RECAPTCHA_SECRET_KEY'];
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    if (empty($recaptchaResponse)) {
        $_SESSION['error'] = "Please complete the reCAPTCHA.";
        header('Location: login.php');
        exit();
    }

    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}");
    $captchaSuccess = json_decode($verify);

    if (!$captchaSuccess || !$captchaSuccess->success) {
        $_SESSION['error'] = "Captcha verification failed. Try again.";
        header('Location: login.php');
        exit();
    }

    $usernameOrEmail = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];     
        $_SESSION['username'] = $user['username'];
        header('Location: home.php');
        exit();
    } else {
        $_SESSION['error'] = "Invalid username/email or password.";
        header('Location: login.php');
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}
