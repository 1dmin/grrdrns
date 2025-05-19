<?php
session_start();
require 'includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
$userId = $user['id'];

// Get cart items for the user
$stmt = $pdo->prepare("
    SELECT c.*, p.price 
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll();

if (empty($cartItems)) {
    // Cart is empty, redirect back to shop or cart page
    header('Location: cart.php');
    exit;
}

// Calculate total amount
$totalAmount = 0;
foreach ($cartItems as $item) {
    $totalAmount += $item['price'] * $item['quantity'];
}

try {
    // Begin transaction
    $pdo->beginTransaction();

    // Insert new order with status 'pending' and current datetime
    $stmt = $pdo->prepare("
        INSERT INTO orders (user_id, total_amount, status, created_at)
        VALUES (?, ?, 'pending', NOW())
    ");
    $stmt->execute([$userId, $totalAmount]);

    // Get the last inserted order ID
    $orderId = $pdo->lastInsertId();

    // Insert order items
    $stmt = $pdo->prepare("
        INSERT INTO order_items (order_id, product_id, quantity, price)
        VALUES (?, ?, ?, ?)
    ");
    foreach ($cartItems as $item) {
        $stmt->execute([
            $orderId,
            $item['product_id'],
            $item['quantity'],
            $item['price']
        ]);
    }

    // Clear user's cart
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->execute([$userId]);

    // Commit transaction
    $pdo->commit();

    // Redirect to orders page or order confirmation page
    header('Location: orders.php?checkout=success');
    exit;

} catch (Exception $e) {
    // Rollback on error
    $pdo->rollBack();
    // For debugging, you might want to display the error or log it
    echo "Checkout failed: " . $e->getMessage();
    exit;
}
?>
