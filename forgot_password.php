  <?php
  session_start();
  require 'includes/db.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  
  require 'vendor/autoload.php'; 

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = $_POST['email'];

      $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
      $stmt->execute([$email]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
          $reset_code = rand(100000, 999999);

          $update = $pdo->prepare("UPDATE users SET reset_code = ? WHERE email = ?");
          $update->execute([$reset_code, $email]);
          $_SESSION['email'] = $email;
          

          $mail = new PHPMailer(true);
          try {
              // Use correct method name
              $mail->isSMTP(); // Correct method to set SMTP
              $mail->Host = 'smtp.gmail.com';
              $mail->SMTPAuth = true;  // Boolean, not string
              $mail->Username = 'a09061407842@gmail.com';
              $mail->Password = 'upun wiyq stbi vdaz';  // Ensure this is your actual app password
              $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
              $mail->Port = 587;

              // Sender's information
              $mail->setFrom('a09061407842@gmail.com', 'JoshyAranasGaming');
              $mail->addAddress($email, 'Client');  // Make sure to use correct recipient details
              $mail->isHTML(true);
              $mail->Subject = 'Password Reset Code';

              // The message body
              $mail->Body = "<p>Hello, This is your password reset code: {$reset_code}</p>";
              $mail->AltBody = "Hello, Use the code to reset the password: \n\n{$reset_code}\n\n";

              // Send the email
              $mail->send();

              // Set session success message
              $_SESSION['email_sent'] = true;
              $_SESSION['success'] = "Verification code has been sent to your email.";
              header('Location: send_code.php');
              exit();

          } catch (Exception $e) {
              // Handle errors and redirect back to the forgot password page
              $_SESSION['error'] = "E rror: {$mail->ErrorInfo}";
              header('Location: forgot_password.php');  // Added missing closing quote here
              exit();
          }

      } else {
          // If user not found
          $_SESSION['error'] = "No user found with that email address.";
          header('Location: forgot_password.php');
          exit();
      }
  }
  ?>
  <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
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

    .container-fluid {
      height: 100vh;
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

    a {
      color: #fcd144;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .form-title {
      font-size: 24px;
      margin-bottom: 20px;
    }

    .alert {
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="container-fluid d-flex">
    <!-- Left Section -->
    <div class="col-md-6 split-left">
      <div>
        <img src="petconnect.png" alt="Logo" style="max-width: 100px;">
        <h2 class="mt-4 fw-bold">Turn your ideas into reality.</h2>
        <p>Start for free and get attractive offers from the community</p>
      </div>
    </div>

    <!-- Right Section -->
    <div class="col-md-6 split-right">
      <div class="form-container">
        <h3 class="form-title text-center">RESET PASSWORD</h3>

        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="forgot_password.php" method="POST">
          <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
          <button type="submit" class="btn btn-orange">Send Reset Code</button>
        </form>

        <div class="text-center mt-3">
          <p><a href="login.php">Back to Login</a></p>
          <p>Don't have an account? <a href="signup.php">Signup</a></p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
