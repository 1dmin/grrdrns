<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up - Pet Connect</title>

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
      max-width: 450px;
    }
    .form-control {
      margin-bottom: 1rem;
      border-radius: 8px;
    }
    .btn-signup {
      background-color: #ff9900;
      color: white;
      border: none;
      border-radius: 8px;
      padding: 0.75rem;
    }
    .btn-signup:hover {
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
        <h2 class="text-center mb-4">Create Your Account</h2>

        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger text-center"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success text-center"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form action="signup_validate.php" method="POST">
          <input class="form-control" type="text" placeholder="First Name" name="firstname" required>
          <input class="form-control" type="text" placeholder="Last Name" name="lastname" required>
          <input class="form-control" type="text" placeholder="Username" name="username" required>
          <input class="form-control" type="email" placeholder="Email" name="email" required>
          <input class="form-control" type="password" placeholder="Password" name="password" required>
          <input class="form-control" type="password" placeholder="Confirm Password" name="confirm_password" required>

          <button type="submit" class="btn btn-signup w-100">Sign Up</button>
        </form>

        <div class="form-links text-center mt-3">
          <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <p>© 2025 Borcelle Pet Shop. All Rights Reserved.</p>
  </footer>
</body>
</html>
