<?php
session_start();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $enteredCode = $_POST['code'];

  if (!isset($_SESSION['email'])) {
    $_SESSION['error'] = "No Email session found, please try again";
    header('Location: forgot_password.php');
    exit();
  }

  $email = $_SESSION['email'];
  $stmt = $pdo->prepare("SELECT reset_code FROM users WHERE email=?");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    if ($enteredCode === $user['reset_code']) {
      $_SESSION['reset_email'] = $email;
      $_SESSION['reset_code_verified'] = true;
      header('Location: reset_code.php');
      exit();
    } else {
      $_SESSION['error'] = "Invalid code, please try again";
    }
  } else {
    $_SESSION['error'] = "No user found with that email";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Enter Reset Code</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

    .form-control {
      border-radius: 5px;
      margin-bottom: 1rem;
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

    .form-title {
      font-size: 24px;
      margin-bottom: 20px;
    }

    .alert {
      font-size: 14px;
    }

    a {
      color: #fcd144;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container-fluid d-flex h-100">
    <!-- Left Panel -->
    <div class="col-md-6 split-left">
      <div>
        <img src="petconnect.png" alt="Logo" style="max-width: 100px;">
        <h2 class="mt-4 fw-bold">Secure your account</h2>
        <p>Enter the reset code we sent to your email.</p>
      </div>
    </div>

    <!-- Right Panel -->
    <div class="col-md-6 split-right">
      <div class="form-container">
        <h3 class="form-title text-center">VERIFY RESET CODE</h3>

        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form action="send_code.php" method="POST">
          <input type="text" name="code" class="form-control" placeholder="Enter Code" required>
          <button type="submit" class="btn btn-orange">Verify Code</button>
        </form>

        <div class="text-center mt-3">
          <a href="forgot_password.php">Back to Forgot Password</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
