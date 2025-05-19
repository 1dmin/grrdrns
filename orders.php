<?php
session_start();
require 'includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo '<pre>SESSION: ';
print_r($_SESSION);
echo '</pre>';

print_r($_SESSION); // to check session data

// For testing only: force user id if missing
if (empty($_SESSION['user']['id'])) {
    $_SESSION['user']['id'] = 1; // set a valid user id manually for testing
}
if (!isset($_SESSION['user']) || empty($_SESSION['user']['id'])) {
  echo "Redirecting to login...";
  header('Location: login.php');
  exit;
}

// Check if user is logged in


$userId = $_SESSION['user']['id'];

// Now you can fetch orders for this user
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$userId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Order History</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>

<h1>Order History</h1>

<?php if (empty($orders)): ?>
    <p>You haven't placed any orders yet. <a href="shop.php">Start shopping!</a></p>
<?php else: ?>
    <ul>
        <?php foreach ($orders as $order): ?>
            <li>
                <strong>Order #<?= htmlspecialchars($order['id']) ?></strong> —
                Placed on <?= date('F j, Y, g:i a', strtotime($order['created_at'])) ?><br>
                Total: $<?= number_format($order['total_amount'], 2) ?><br>
                Status: <?= htmlspecialchars(ucfirst($order['status'])) ?><br>
                Shipping Address: <?= nl2br(htmlspecialchars($order['shipping_address'])) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

</body>
</html>
