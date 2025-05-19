<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['reset_code_verified']) || !isset($_SESSION['reset_email'])) {
    $_SESSION['error'] = "Unauthorized access.";
    header('Location: send_code.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword === $confirmPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([$hashedPassword, $_SESSION['reset_email']]);

        unset($_SESSION['reset_email'], $_SESSION['reset_code_verified']);

        $_SESSION['success'] = "Your password has been reset successfully. You can now login.";
        header('Location: login.php');
        exit();
    } else {
        $_SESSION['error'] = "Passwords do not match. Please try again.";
        header('Location: reset_code.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reset Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    .split-left {
      background-color: #fcebd1;
      color: #4a2342;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
      text-align: center;
    }

    .split-right {
      background-color: #3a3a3a;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
    }

    .form-container {
      width: 100%;
      max-width: 400px;
    }

    .form-title {
      font-size: 24px;
      margin-bottom: 20px;
    }

    .form-control {
      border-radius: 5px;
      margin-bottom: 1rem;
      padding: 0.75rem;
      font-size: 1rem;
    }

    .btn-orange {
      background-color: orange;
      border: none;
      color: white;
      padding: 10px;
      width: 100%;
      border-radius: 5px;
      font-weight: bold;
    }

    .btn-orange:hover {
      background-color: darkorange;
    }

    .alert {
      font-size: 14px;
    }

    footer {
      text-align: center;
      padding: 1rem;
      font-size: 0.9rem;
      color: #aaa;
      background-color: #2c2c2c;
    }
  </style>
</head>
<body>
  <div class="container-fluid d-flex h-100">
    <!-- Left Panel -->
    <div class="col-md-6 split-left">
      <div>
        <img src="petconnect.png" alt="Logo" style="max-width: 100px;" />
        <h2 class="mt-4 fw-bold">Reset Your Password</h2>
        <p>Choose a strong and secure password to protect your account.</p>
      </div>
    </div>

    <!-- Right Panel -->
    <div class="col-md-6 split-right">
      <div class="form-container">
        <h3 class="form-title text-center">SET NEW PASSWORD</h3>

        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form action="reset_code.php" method="POST">
          <input type="password" name="password" class="form-control" placeholder="New Password" required />
          <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required />
          <button type="submit" class="btn btn-orange">Reset Password</button>
        </form>
      </div>
    </div>
  </div>

  <footer>
    <p>© 2025 Borcelle Pet Shop. All Rights Reserved.</p>
  </footer>
</body>
</html>
