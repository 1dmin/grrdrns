<?php
require 'includes/db.php';

$products = [
    ['Dog Toy Bone', 9.99, 'images/toy_bone.jpg'],
    ['Cat Scratching Post', 19.99, 'images/scratching_post.jpg'],
    ['Pet Shampoo', 5.50, 'images/pet_shampoo.jpg']
];

$stmt = $pdo->prepare("INSERT INTO products (name, price, image_url) VALUES (?, ?, ?)");

foreach ($products as $product) {
    $stmt->execute($product);
}

echo "Sample products inserted.";
