<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Buyer Information - PetConnect</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .buyer-form-container {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 500px;
    }

    .buyer-form-container h1 {
      color: #ff6600;
      text-align: center;
      margin-bottom: 30px;
    }

    .buyer-label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }

    .buyer-input, .buyer-textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    .buyer-submit-btn {
      background-color: #ff6600;
      color: white;
      padding: 12px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      width: 100%;
      margin-top: 25px;
      cursor: pointer;
    }

    .buyer-submit-btn:hover {
      background-color: #e65c00;
    }
  </style>
</head>
<body>

<div class="buyer-form-container">
  <h1>Enter Buyer Info</h1>
  <form id="buyerForm">
    <label for="name" class="buyer-label">Full Name</label>
    <input type="text" id="name" class="buyer-input" required />

    <label for="email" class="buyer-label">Email</label>
    <input type="email" id="email" class="buyer-input" required />

    <label for="contact" class="buyer-label">Contact Number</label>
    <input type="tel" id="contact" class="buyer-input" required pattern="[0-9]{10,15}" placeholder="e.g. 09171234567" />

    <label for="address" class="buyer-label">Shipping Address</label>
    <textarea id="address" class="buyer-textarea" rows="4" required></textarea>

    <button type="submit" class="buyer-submit-btn">Continue to Checkout</button>
  </form>
</div>

<script>
  document.getElementById('buyerForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const buyerInfo = {
      name: document.getElementById('name').value.trim(),
      email: document.getElementById('email').value.trim(),
      contact: document.getElementById('contact').value.trim(),
      address: document.getElementById('address').value.trim()
    };

    localStorage.setItem('buyerInfo', JSON.stringify(buyerInfo));
    window.location.href = 'checkout.php';
  });
</script>

</body>
</html>
