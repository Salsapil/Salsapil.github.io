<?php

// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include Composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Check the request method and URI
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'POST' && $requestUri === '/save_product') {
    require_once __DIR__ . '/controllers/save_products.php'; // Handle saving product
} else {
    require_once __DIR__ . '/controllers/product_list.php'; // Show product list
}
?>
