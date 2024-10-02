<?php

// Enable detailed error reporting to capture any underlying issue
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Log errors to a file instead of displaying them
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../php-error.log');
ini_set('display_errors', 0);

// Ensure the response is always JSON
header('Content-Type: application/json');

// Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get the raw POST data (JSON)
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Log the received data for debugging
error_log("Received data for deletion: " . print_r($data, true));

// Ensure 'ids' (SKUs) are present and are an array
if (!isset($data['ids']) || !is_array($data['ids'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Invalid input, SKUs are missing or not an array']);
    exit;
}

use App\Classes\Database;

// Include the database connection class
require_once __DIR__ . '/../classes/Database.php';

try {
    // Get the database connection
    $db = (new Database())->getConnection();

    // Prepare and execute the deletion query based on SKUs
    $skus = implode(',', array_map(function ($sku) use ($db) {
        return $db->quote($sku); // Sanitize input using PDO
    }, $data['ids'])); // 'ids' contains SKU values

    // Log the query for debugging
    $query = "DELETE FROM products WHERE sku IN ($skus)";
    error_log("Executing query: $query");

    $stmt = $db->prepare($query);

    if ($stmt->execute()) {
        // If successful, return a JSON response
        echo json_encode(['success' => true, 'message' => 'Products deleted successfully.']);
    } else {
        // If the query fails, log the error and return a 500 response
        error_log("SQL Error: " . print_r($stmt->errorInfo(), true));
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'message' => 'Failed to delete products due to a SQL error.']);
    }
} catch (PDOException $e) {
    // Log PDOException details
    error_log("Database error: " . $e->getMessage());
    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Log general exceptions
    error_log("General error: " . $e->getMessage());
    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
