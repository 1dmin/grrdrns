<?php
require 'includes/db.php';

try {
    // Sample products data
    $products = [
        [
            'name' => 'Premium Pet Food',
            'description' => 'High-quality pet food made with natural ingredients',
            'price' => 25.99,
            'image_url' => 'food.jpg',
            'stock' => 100
        ],
        [
            'name' => 'Interactive Toy',
            'description' => 'Engaging toy to keep your pet entertained',
            'price' => 15.99,
            'image_url' => 'toy.jpg',
            'stock' => 50
        ],
        [
            'name' => 'Grooming Kit',
            'description' => 'Complete grooming kit for your pet',
            'price' => 30.00,
            'image_url' => 'grooming.png',
            'stock' => 30
        ],
        [
            'name' => 'Cozy Pet Bed',
            'description' => 'Comfortable bed for your pet to rest',
            'price' => 45.00,
            'image_url' => 'bed.jpg',
            'stock' => 20
        ],
        [
            'name' => 'Durable Pet Leash',
            'description' => 'Strong and reliable leash for walks',
            'price' => 20.00,
            'image_url' => 'leash.jpg',
            'stock' => 40
        ],
        [
            'name' => 'Stainless Steel Bowl',
            'description' => 'Durable and easy to clean food bowl',
            'price' => 10.99,
            'image_url' => 'bowl.jpg',
            'stock' => 60
        ],
        [
            'name' => 'Portable Pet Carrier',
            'description' => 'Comfortable carrier for traveling with your pet',
            'price' => 55.99,
            'image_url' => 'carrier.jpg',
            'stock' => 15
        ],
        [
            'name' => 'Natural Pet Shampoo',
            'description' => 'Gentle shampoo made with natural ingredients',
            'price' => 12.99,
            'image_url' => 'shampoo.jpg',
            'stock' => 45
        ],
        [
            'name' => 'Cat Scratcher',
            'description' => 'Durable scratching post for cats',
            'price' => 28.50,
            'image_url' => 'scratcher.jpg',
            'stock' => 25
        ],
        [
            'name' => 'Healthy Pet Treats',
            'description' => 'Nutritious treats for your pet',
            'price' => 9.99,
            'image_url' => 'treats.jpg',
            'stock' => 80
        ]
    ];

    // Insert products
    $stmt = $pdo->prepare("
        INSERT INTO products (name, description, price, image_url, stock)
        VALUES (?, ?, ?, ?, ?)
    ");

    foreach ($products as $product) {
        $stmt->execute([
            $product['name'],
            $product['description'],
            $product['price'],
            $product['image_url'],
            $product['stock']
        ]);
    }

    echo "Sample products added successfully!";
} catch (PDOException $e) {
    echo "Error adding products: " . $e->getMessage();
}
?> 