    <?php
    session_start();
    require 'includes/db.php';

    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit;
    }

    $userId = $_SESSION['user']['id'];

    // Initialize cart if not already set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Handle POST requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = max(0, (int)($_POST['quantity'] ?? 0));

        if ($productId > 0) {
            switch ($action) {
                case 'add':
                    $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + max(1, $quantity);
                    $_SESSION['flash_message'] = "Item added to cart!";
                    break;
                case 'update':
                    if ($quantity > 0) {
                        $_SESSION['cart'][$productId] = $quantity;
                    } else {
                        unset($_SESSION['cart'][$productId]);
                    }
                    break;
                case 'remove':
                    unset($_SESSION['cart'][$productId]);
                    break;
            }
        }
        header('Location: cart.php');
        exit;
    }

    // Fetch product details
    $productIds = array_keys($_SESSION['cart']);
    $cartItems = [];
    $total = 0;

    if (!empty($productIds)) {
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));
        $stmt = $pdo->prepare("SELECT id, name, price, image_url FROM products WHERE id IN ($placeholders)");
        $stmt->execute($productIds);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($products as $product) {
            $pid = $product['id'];
            $qty = $_SESSION['cart'][$pid] ?? 0;
            $subtotal = $product['price'] * $qty;
            $total += $subtotal;

            $cartItems[] = [
                'id' => $pid,
                'name' => $product['name'],
                'price' => $product['price'],
                'image_url' => $product['image_url'],
                'quantity' => $qty,
                'subtotal' => $subtotal
            ];
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Shopping Cart - PetConnect</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>

    <?php if (isset($_SESSION['flash_message'])): ?>
    <script>alert("<?= htmlspecialchars($_SESSION['flash_message']) ?>");</script>
    <?php unset($_SESSION['flash_message']); endif; ?>

    <header>
        <div class="logo">🐾 PetConnect</div>
        <nav>
            <a href="Home.php">🏠 Home</a>
            <a href="adopt.php">❤️ Adopt</a>
            <a href="community.php">👥 Community</a>
            <a href="appointments.php">📅 Appointments</a>
            <a href="shop.php">🛒 Shop</a>
            <a href="notifications.php" title="Notifications">🔔</a>
            <a href="cart.php" title="View Cart" class="active">🛍️</a>
            <div class="dropdown">
                <button class="dropbtn">⚙️ Account ▼</button>
                <div class="dropdown-content">
                    <a href="profile.php">Profile</a>
                    <a href="pet_records.php">Manage Pets</a>
                    <a href="reminders.php">Reminders</a>
                    <a href="logout_confirmation.php">Logout</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="cart-container">
        <h1>Your Shopping Cart</h1>
        <?php if (empty($cartItems)): ?>
            <p class="empty-cart">Your cart is empty. <a href="shop.php">Start shopping!</a></p>
        <?php else: ?>
            <?php foreach ($cartItems as $item): ?>
                <form method="POST" style="display:flex; align-items:center; margin-bottom:15px; border-bottom:1px solid #eee; padding-bottom:15px;">
                    <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="80" height="80">
                    <div class="cart-details">
                        <h3><?= htmlspecialchars($item['name']) ?></h3>
                        <p>$<?= number_format($item['price'], 2) ?></p>
                        <div class="cart-actions">
                            <label for="qty_<?= $item['id'] ?>">Quantity:</label>
                            <input type="number" name="quantity" id="qty_<?= $item['id'] ?>" value="<?= $item['quantity'] ?>" min="0">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <button type="submit" name="action" value="update">Update</button>
                            <button type="submit" name="action" value="remove" onclick="return confirm('Remove this item?')">Remove</button>
                        </div>
                    </div>
                </form>
            <?php endforeach; ?>
            <p class="cart-total">Total: $<?= number_format($total, 2) ?></p>
            <form action="checkout.php" method="POST">
    <input type="hidden" name="total" value="<?= htmlspecialchars($total) ?>">
    <button type="submit">Proceed to Checkout</button>
</form>

        <?php endif; ?>
    </div>

    </body>
    </html>
