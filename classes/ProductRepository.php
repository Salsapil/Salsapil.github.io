<?php

namespace App\Classes;

use App\Classes\ProductFactory;
use PDO;

class ProductRepository
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function getAllProducts()
    {
        $query = "SELECT * FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Log the fetched row for debugging
            error_log("Fetched Row: " . print_r($row, true));

            $attributes = [
                'size' => $row['size'] ?? null,
                'weight' => $row['weight'] ?? null,
            ];

            // Handle dimensions if the product is Furniture
            if ($row['type'] === 'Furniture') {
                if (isset($row['dimensions'])) {
                    // Assuming dimensions are stored as 'heightxwidthxlength' (e.g., '10x20x30')
                    list($height, $width, $length) = explode('x', $row['dimensions']);
                    $attributes['height'] = (float)$height;
                    $attributes['width'] = (float)$width;
                    $attributes['length'] = (float)$length;
                } else {
                    $attributes['height'] = 0;
                    $attributes['width'] = 0;
                    $attributes['length'] = 0;
                }
            }

            // Use the factory to create the correct product object dynamically
            $products[] = ProductFactory::createProduct(
                $row['type'],
                $row['sku'],
                $row['name'],
                $row['price'],
                $attributes
            );
        }

        return $products;
    }

    public function saveProduct(Product $product)
    {
        // Use reflection to call the save method on the product class
        return $product->save();
    }
}
