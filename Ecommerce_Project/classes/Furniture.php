<?php

namespace App\Classes;

use App\Classes\Product;

class Furniture extends Product
{
    private string $dimensions;

    public function __construct(string $sku, string $name, float $price, array $attributes)
    {
        parent::__construct($sku, $name, $price);
        $this->setDimensions($attributes); // Set dimensions using attributes
    }

    private function setDimensions(array $attributes): void
    {
        $height = $attributes['height'] ?? 0;
        $width = $attributes['width'] ?? 0;
        $length = $attributes['length'] ?? 0;

        // Check if any dimension is invalid or not provided
        if ($height <= 0 || $width <= 0 || $length <= 0) {
            throw new \InvalidArgumentException(
                "Invalid dimensions provided. Height: $height, Width: $width, Length: $length. " .
                "All must be greater than 0."
            );
        }

        $this->dimensions = "{$height}x{$width}x{$length}";
    }

    public function displaySpecificDetails(): void
    {
        echo "<p>Dimensions: {$this->dimensions}</p>";
    }

    public function save(): bool
    {
        $query = "INSERT INTO products (sku, name, price, type, dimensions) VALUES " .
         "(:sku, :name, :price, 'Furniture', :dimensions)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sku', $this->sku);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':dimensions', $this->dimensions);

        return $stmt->execute();
    }
}
