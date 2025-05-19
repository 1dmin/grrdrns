<?php

session_start();
require 'includes/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $_SESSION['error'] ="Password does not match";
        header('Location: signup.php');
        exit();

    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    
    if ($stmt->rowCount() > 0 ) {
        $_SESSION['error'] = "Username already exists.";
        header('Location: signup.php');
        exit();
        }
        if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($password) || empty($confirm)) {
            $_SESSION['error'] = "Please fill in all fields.";
            header('Location: signup.php');
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, username, email, password) VALUES (?,?,?,?,?)");
      $stmt->execute ([$firstname, $lastname, $username, $email,$hashedPassword]);

      $_SESSION['success'] = "Your account has been created. You can now Login.";
        header('Location: login.php');
        exit();

} else {
    echo ("there's an error");
    exit();
}
