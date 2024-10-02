<?php

declare(strict_types=1);

use App\Classes\ProductFactory;
use App\Classes\Database;

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload classes

// Enable error reporting for debugging
ini_set('display_errors', '1');
error_reporting(E_ALL);

// Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get the raw POST data (JSON)
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validate required fields
$requiredFields = ['sku', 'name', 'price', 'type', 'attributes'];
foreach ($requiredFields as $field) {
    if (!isset($data[$field])) {
        http_response_code(400); // Bad Request
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => "Missing required field: $field"]);
        exit;
    }
}

try {
    // Establish a database connection
    $db = (new Database())->getConnection();

    // Check if SKU already exists
    $sku = $data['sku'];
    $stmt = $db->prepare("SELECT COUNT(*) FROM products WHERE sku = :sku");
    $stmt->execute(['sku' => $sku]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        http_response_code(400); // Bad Request
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'SKU must be unique.']);
        exit;
    }

    // Create the product object using the ProductFactory
    $product = ProductFactory::createProduct(
        $data['type'],
        $data['sku'],
        $data['name'],
        (float)$data['price'],
        $data['attributes']
    );

    // Save the product using the save method
    if ($product->save()) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Failed to save product');
    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
