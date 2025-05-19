<?php
$message = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success') {
        $message = '<p style="color: green; font-weight: bold;">Thank you! Your message was sent successfully.</p>';
    } elseif ($_GET['status'] === 'error') {
        $message = '<p style="color: red; font-weight: bold;">Oops! There was an error sending your message. Please check your input and try again.</p>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact Us - PetConnect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f5f1ea;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #555;
    }
    .navbar {
      background-color: #9e947f;
    }
    .navbar-brand, .nav-link {
      color: #f5f1ea !important;
      font-weight: 600;
    }
    .nav-link:hover {
      color: #e3ded6 !important;
    }
    .header-section {
        background: url('dog1.jpg') no-repeat center center/cover;
  padding: 6rem 2rem;
  color: #fff;
  text-align: center;
  background-blend-mode: multiply;
  background-color: rgba(122, 111, 99, 0.6); /* soft beige-brown overlay */
}
.header-section h1 {
  font-weight: 800;
  text-shadow: 1px 1px 4px rgba(0,0,0,0.5);
}
.header-section p {
  font-size: 1.2rem;
  max-width: 700px;
  margin: 1rem auto 0;
  text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

    .contact-box {
      background-color: #fff;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(122, 111, 99, 0.2);
    }
    .form-control, .btn {
      border-radius: 10px;
    }
    .btn-pet {
      background-color: #7a6f63;
      color: #f5f1ea;
    }
    .btn-pet:hover {
      background-color: #5f574b;    
    }
    .info-icon {
      font-size: 2rem;
      color: #7a6f63;
    }
    footer {
      background-color: #7a6f63;
      color: #f5f1ea;
      padding: 1rem;
      text-align: center;
      margin-top: 3rem;
    }
  </style>
</head>
<body>
<?php echo $message; ?>

  <nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="index.php">🐾 PetConnect</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="landingpage.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login / Signup</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="header-section">
    <div class="container">
      <h1>We're Here to Help!</h1>
      <p class="lead">Got a question about adoption, pet care, or just want to say hello? Drop us a message below!</p>
    </div>
  </section>

  <section class="py-5">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-6">
          <div class="contact-box">
            <h2 class="mb-4">Send Us a Message</h2>
            <form action="contact_submit.php" method="POST">
              <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="mb-3">
                <label for="reason" class="form-label">Reason for Contact</label>
                <select class="form-select" id="reason" name="reason">
                  <option value="Adoption Inquiry">Adoption Inquiry</option>
                  <option value="Support">Technical Support</option>
                  <option value="Volunteer">Volunteer with Us</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
              </div>
              <button type="submit" class="btn btn-pet w-100">Send Message</button>
            </form>
          </div>
        </div>
        <div class="col-lg-6 d-flex align-items-center">
          <div>
            <h3 class="mb-4">How Else Can We Help?</h3>
            <p><i class="bi bi-envelope-fill info-icon"></i> Email: support@petconnect.com</p>
            <p><i class="bi bi-telephone-fill info-icon"></i> Phone: +1 (555) 123-4567</p>
            <p><i class="bi bi-geo-alt-fill info-icon"></i> Visit: 123 Paw Street, Petville, USA</p>
            <p>We aim to respond within 24 hours on weekdays. For urgent pet emergencies, please contact your local vet clinic immediately.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <p>© 2025 PetConnect. All Rights Reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
