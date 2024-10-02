<?php

namespace App\Classes;

use App\Classes\DVD;
use App\Classes\Book;
use App\Classes\Furniture;

class ProductFactory
{
    private static array $productClasses = [
        'DVD' => DVD::class,
        'Book' => Book::class,
        'Furniture' => Furniture::class,
    ];

    public static function createProduct(
        string $type,
        string $sku,
        string $name,
        float $price,
        array $attributes
    ): Product {
        if (!isset(self::$productClasses[$type])) {
            throw new \InvalidArgumentException("Invalid product type: $type");
        }

        $productClass = self::$productClasses[$type];

        return new $productClass($sku, $name, $price, $attributes); // Ensure attributes are passed correctly
    }
}
