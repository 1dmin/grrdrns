<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PetConnect - Your Pet’s Best Friend</title>
  <style>
    /* Reset & base */
    * {
      box-sizing: border-box;
      margin: 0; padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    body {
      background: #f5f1ea; /* light beige */
      color: #555555; /* medium gray */
      line-height: 1.6;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    a {
      color: #7a6f63; /* darker beige/gray */
      text-decoration: none;
      transition: color 0.3s ease;
    }
    a:hover {
      color: #9e947f;
    }

    header {
      background: #9e947f; /* medium beige/gray */
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: #f5f1ea; /* light beige text */
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .logoL {
      font-size: 1.8rem;
      font-weight: 700;
      user-select: none;
    }
    nav a {
      margin-left: 1.5rem;
      font-weight: 600;
    }
    nav a:last-child {
      background: #7a6f63; /* darker beige */
      padding: 0.5rem 1rem;
      border-radius: 4px;
      color: #f5f1ea;
    }
    nav a:last-child:hover {
      background: #5f574b;
    }

    .heroL {
      background: url('https://images.unsplash.com/photo-1518717758536-85ae29035b6d?auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover;
      color: #f5f1ea; /* light beige */
      text-align: center;
      padding: 6rem 1rem 4rem;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .heroL .text-contentL {
      max-width: 600px;
      margin: 0 auto;
      background: rgba(122, 111, 99, 0.85); /* semi-transparent beige-gray overlay */
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(122, 111, 99, 0.5);
    }
    .heroL h1 {
      font-size: 3rem;
      margin-bottom: 1rem;
      font-weight: 800;
      text-shadow: 1px 1px 4px rgba(0,0,0,0.4);
    }
    .heroL p {
      font-size: 1.2rem;
      margin-bottom: 2rem;
      line-height: 1.5;
    }
    .learn-moreL {
      background: #7a6f63; /* darker beige */
      border: none;
      padding: 0.75rem 2rem;
      font-size: 1.1rem;
      font-weight: 700;
      color: #f5f1ea;
      border-radius: 30px;
      cursor: pointer;
      box-shadow: 0 6px 10px rgba(122, 111, 99, 0.5);
      transition: background-color 0.3s ease;
    }
    .learn-moreL:hover {
      background: #5f574b;
    }

    .featuresL {
      padding: 4rem 2rem;
      background: #f5f1ea; /* light beige */
      text-align: center;
      max-width: 900px;
      margin: 0 auto 3rem;
      color: #555555; /* medium gray */
    }
    .featuresL h2 {
      font-size: 2.5rem;
      margin-bottom: 2rem;
      color: #7a6f63; /* medium beige */
    }
    .feature-gridL {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 2rem;
    }
    .feature-itemL {
      background: #e3ded6; /* very light beige/gray */
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(122, 111, 99, 0.15);
      transition: transform 0.3s ease;
      cursor: default;
    }
    .feature-itemL:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 20px rgba(122, 111, 99, 0.25);
    }
    .feature-itemL h3 {
      font-size: 1.5rem;
      margin-bottom: 1rem;
      color: #5f574b; /* darker beige */
    }
    .feature-itemL p {
      font-size: 1.1rem;
      color: #555555;
    }

    footer {
      text-align: center;
      padding: 1rem 2rem;
      background: #7a6f63; /* medium beige */
      color: #f5f1ea;
      font-weight: 600;
      user-select: none;
    }

    /* Responsive */
    @media (max-width: 600px) {
      .heroL h1 {
        font-size: 2rem;
      }
      .featuresL h2 {
        font-size: 1.8rem;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="logoL">🐾 PetConnect</div>
    <nav>
      <a href="contact.php">Contact</a>
      <a href="login.php">Login / Signup</a>
    </nav>
  </header>

  <section class="heroL">
    <div class="text-contentL">
      <h1>Welcome to PetConnect</h1>
      <p>Your one-stop destination for all your pet's needs. Adopt, book appointments, and explore our range of pet supplies.</p>
      <a href="learn_more.php"><button class="learn-moreL">Learn More</button></a>
    </div>
  </section>

  <section class="featuresL">
    <h2>Why Choose Us?</h2>
    <div class="feature-gridL">
      <div class="feature-itemL">
        <h3>🐶 Pet Adoption</h3>
        <p>Find your perfect furry friend and give them a loving home.</p>
      </div>
      <div class="feature-itemL">
        <h3>🛒 Pet Supplies</h3>
        <p>Shop high-quality pet foods, toys, and accessories.</p>
      </div>
      <div class="feature-itemL">
        <h3>🏥 Vet Appointments</h3>
        <p>Book your pet's health checkups with ease and confidence.</p>
      </div>
      <div class="feature-itemL">
        <h3>🏥 Pet Community</h3>
        <p>Chitchat with other pet owners within your community.</p>
      </div>
    </div>
  </section>

  <footer>
    <p>© 2025 PetConnect. All Rights Reserved.</p>
  </footer>
</body>
</html>
