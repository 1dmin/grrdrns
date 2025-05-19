<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Learn More - PetConnect</title>
  <style>
    /* Base styles matching landing page */
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
      color: #7a6f63;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    a:hover {
      color: #9e947f;
    }

    header {
      background: #9e947f;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: #f5f1ea;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      user-select: none;
    }
    .lm-logo {
      font-size: 1.8rem;
      font-weight: 700;
      user-select: none;
    }
    nav a {
      margin-left: 1.5rem;
      font-weight: 600;
    }
    nav a:hover {
      color: #f5f1ea;
    }

    main {
      max-width: 900px;
      margin: 3rem auto 4rem;
      padding: 0 1rem;
      flex-grow: 1;
    }
    h1, h2 {
      color: #7a6f63;
      margin-bottom: 1rem;
      font-weight: 800;
    }
    h1 {
      font-size: 2.8rem;
      text-align: center;
      margin-bottom: 2rem;
    }
    h2 {
      font-size: 2rem;
      margin-top: 3rem;
    }
    p {
      font-size: 1.1rem;
      margin-bottom: 1.5rem;
      color: #555555;
    }

    ul {
      list-style: none;
      padding-left: 1rem;
      color: #555555;
      margin-top: 1rem;
    }
    ul li {
      margin-bottom: 0.8rem;
      padding-left: 1.4rem;
      position: relative;
      font-weight: 600;
    }
    ul li::before {
      content: "✔️";
      position: absolute;
      left: 0;
      color: #7a6f63;
    }

    .lm-features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 1.8rem;
      margin-top: 2rem;
    }
    .lm-feature-box {
      background: #e3ded6;
      padding: 1.8rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(122, 111, 99, 0.15);
      transition: transform 0.3s ease;
    }
    .lm-feature-box:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 20px rgba(122, 111, 99, 0.25);
    }
    .lm-feature-box h2 {
      font-size: 1.4rem;
      margin-bottom: 0.8rem;
      color: #5f574b;
    }
    .lm-feature-box p {
      font-weight: 500;
    }

    .lm-cta-section {
      text-align: center;
      margin-top: 4rem;
      background: #9e947f;
      color: #f5f1ea;
      padding: 3rem 1rem;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(122,111,99,0.4);
    }
    .lm-cta-section h2 {
      font-size: 2.2rem;
      margin-bottom: 1rem;
      font-weight: 800;
    }
    .lm-cta-section p {
      font-size: 1.2rem;
      margin-bottom: 2rem;
    }
    .lm-cta-button {
      background: #7a6f63;
      color: #f5f1ea;
      border: none;
      padding: 0.85rem 3rem;
      font-size: 1.2rem;
      font-weight: 700;
      border-radius: 30px;
      cursor: pointer;
      box-shadow: 0 6px 12px rgba(122,111,99,0.5);
      transition: background-color 0.3s ease;
    }
    .lm-cta-button:hover {
      background: #5f574b;
    }

    footer {
      text-align: center;
      padding: 1rem 2rem;
      background: #7a6f63;
      color: #f5f1ea;
      font-weight: 600;
      user-select: none;
    }

    @media (max-width: 600px) {
      h1 {
        font-size: 2rem;
      }
      h2 {
        font-size: 1.5rem;
      }
      .lm-features-grid {
        grid-template-columns: 1fr;
      }
      .header-section {
  position: relative;
  background-size: cover;
  background-position: center;
  height: 1000px; /* increased from 180px */
  border-radius: 12px;
  margin-bottom: 1.5rem;
  box-shadow: 0 4px 12px rgba(122, 111, 99, 0.15);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #f5f1ea; /* light beige text */
  font-weight: 800;
  font-size: 2.4rem; /* slightly bigger text to match */
  text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.6);
}


.header-section::before {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(122, 111, 99, 0.65); /* semi-transparent beige overlay */
  border-radius: 12px;
  z-index: 0;
}

.header-section > * {
  position: relative;
  z-index: 1;
}

    }
  </style>
</head>
<body>
  <header>
    <div class="lm-logo">🐾 PetConnect</div>
    <nav>
      <a href="landingpage.php">Home</a>
      <a href="#">Contact</a>
      <a href="login.php">Login / Signup</a>
    </nav>
  </header>

  <main>
    <h1>Learn More About PetConnect</h1>

    <section>
  </div>
  <h2>About Petconnect</h2>
  <p>PetConnect is your trusted companion for everything pets — from adoption, healthcare appointments, grooming, to buying high-quality pet supplies. We are committed to making your pet ownership journey smooth, joyful, and full of support.</p>
</section>  

    <section>
      <h2>Our Mission &amp; Vision</h2>
      <p>At PetConnect, our mission is to bridge the gap between loving pet owners and quality pet services. We envision a world where every pet is healthy, happy, and cared for — effortlessly.</p>
    </section>

    <section>
      <h2>How It Works</h2>
      <p>Sign up, create your pet’s profile, and immediately gain access to trusted adoption services, book vet or grooming appointments, shop essential products, and receive timely care reminders — all in one platform!</p>
    </section>

    <section class="lm-features-grid">
      <div class="lm-feature-box">
        <h2>🐾 Easy Pet Adoption</h2>
        <p>Find verified pets needing loving homes. Browse by type, breed, size, and location.</p>
      </div>
      <div class="lm-feature-box">
        <h2>🏥 Vet &amp; Grooming Appointments</h2>
        <p>Schedule and manage appointments with trusted service providers with just a few taps.</p>
      </div>
      <div class="lm-feature-box">
        <h2>🛒 Premium Pet Supplies</h2>
        <p>Shop quality food, toys, grooming kits, and more. Delivered conveniently to your door.</p>
      </div>
    </section>

    <section class="lm-benefits-section">
      <h2>Why PetConnect?</h2>
      <p>Here’s why thousands of pet owners trust us:</p>
      <ul>
        <li>Centralized management for all pet needs</li>
        <li>Verified and trusted service providers</li>
        <li>Secure and user-friendly platform</li>
        <li>Save time, money, and effort</li>
        <li>Community support and expert advice</li>
      </ul>
    </section>

    <section class="lm-cta-section">
      <h2>Ready to Join PetConnect?</h2>
      <p>Sign up today and simplify your pet’s care journey. It's fast, free, and made just for you and your furry companions!</p>
      <button class="lm-cta-button" onclick="window.location.href='signup.php'">Get Started</button>
    </section>
  </main>

  <footer>
    <p>© 2025 PetConnect. All Rights Reserved.</p>
  </footer>
</body>
</html>
