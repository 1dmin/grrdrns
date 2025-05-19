<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
$_SESSION['user'] = ['name' => $userNameFromDb];
$_SESSION['user_id'] = $user['id'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$siteKey = $_ENV['RECAPTCHA_SITE_KEY'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Pet Connect</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .split-left {
      background-color: #fdebd3;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 2rem;
      text-align: center;
    }
    .split-left img {
      width: 120px;
      margin-bottom: 1rem;
    }
    .split-left h4 {
      font-weight: bold;
      color: #5a2a4a;
    }
    .split-left p {
      color: #7a4e65;
    }

    .split-right {
      background-color: #4c4c4c;
      color: white;
      padding: 2rem;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .form-container {
      width: 100%;
      max-width: 400px;
    }
    .form-control {
      margin-bottom: 1rem;
      border-radius: 8px;
    }
    .btn-login {
      background-color: #ff9900;
      color: white;
      border: none;
      border-radius: 8px;
      padding: 0.75rem;
    }
    .btn-login:hover {
      background-color: #e68a00;
    }
    .alert {
      border-radius: 8px;
    }
    a {
      text-decoration: none;
    }
    .form-links a {
      color: #ffd700;
    }
    footer {
      text-align: center;
      padding: 1rem;
      font-size: 0.9rem;
      color: #666;
      background-color: #f1f1f1;
    }
    .g-recaptcha {
  display: block;
  margin: 0 auto;
}
.recaptcha-center {
  display: flex;
  justify-content: center;
  margin: 1rem 0;
}
  </style>
</head>
<body>
  <div class="container-fluid min-vh-100 p-0 d-flex">
    <!-- Left Panel -->
    <div class="col-md-6 split-left d-none d-md-flex">
      <img src="petconnect.png" alt="Pet Shop Logo">
      <h4>Turn your ideas into reality.</h4>
      <p>Start for free and get attractive offers from the community</p>
    </div>

    <!-- Right Panel -->
    <div class="col-md-6 split-right">
      <div class="form-container">
        <h2 class="text-center mb-4">LOGIN</h2>

        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger text-center"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success text-center"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form action="login_validate.php" method="POST">
  <input class="form-control" type="text" name="username" placeholder="Username or Email" required>
  <input class="form-control" type="password" name="password" placeholder="Password" required>
  <div class="recaptcha-center">
    <div class="g-recaptcha" data-sitekey="<?= htmlspecialchars($siteKey) ?>"></div>
  </div>
  <button type="submit" class="btn btn-login w-100">Login</button>
</form>

        <div class="form-links text-center mt-3">
          <p>DONT HAVE AN ACCOUNT? <a href="signup.php">SIGNUP</a></p>
          <p>Not Registered Yet? <a href="signup.php">Create an account</a></p>
          <p>Forgot password? <a href="forgot_password.php">Reset Password</a></p>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <p>© 2025 Borcelle Pet Shop. All Rights Reserved.</p>
  </footer>

  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>
