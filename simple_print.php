<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/includes/db.php';
    

    $mpdf = new \Mpdf\Mpdf([
        'tempDir' => __DIR__ . '/tmp'
    ]);

    // No need for header('Content-Type: application/pdf'); mPDF handles it itself!

    // Fetch products
    $stmt = $pdo->query('SELECT * FROM products');
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = 1;

    // Build HTML
    $html = '
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
                padding: 20px;
                color: #333;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #ccc;
                padding: 8px;
                text-align: left;
            }
            thead {
                background-color: #f5f5f5;
            }
            .signature-section {
                margin-top: 50px;
                text-align: center;
            }
            .signature p {
                margin: 0;
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <h4>Product List</h4>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>';

    foreach ($products as $product) {
        $html .= '
            <tr>
                <td>' . $count++ . '</td>
                <td>' . htmlspecialchars($product['product_name']) . '</td>
                <td>' . htmlspecialchars($product['category']) . '</td>
                <td>' . htmlspecialchars($product['price']) . '</td>
                <td>' . htmlspecialchars($product['stock']) . '</td>
            </tr>';
    }

    $html .= '
            </tbody>
        </table>

        <div class="signature-section">
            <div class="signature">
                <p>______________________________________</p>
                <p><strong>Gerardo B. Aranas Jr</strong></p>
            </div>
        </div>
    </body>
    </html>';


    $mpdf->SetHTMLFooter('
        <div style="text-align: center;">
            Page {PAGENO} of {nbpg}
        </div>
    ');

    $mpdf->WriteHTML($html);
    $mpdf->Output('product-list.pdf', 'I');

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
</head>
<body>
    <div class="container mt-5">
        <form method="POST" action="">
            <button type="submit" class="btn btn-primary">
                <i class="mdi mdi-printer"></i> Print Products
            </button>
        </form>
    </div>
</body>
</html>
