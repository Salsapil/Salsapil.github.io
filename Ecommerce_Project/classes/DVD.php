<?php

namespace App\Classes;

use App\Classes\Product;

class DVD extends Product
{
    private int $size;

    public function __construct(string $sku, string $name, float $price, array $attributes)
    {
        parent::__construct($sku, $name, $price);
        $this->size = $attributes['size'];
    }

    public function displaySpecificDetails(): void
    {
        echo "<p>Size: {$this->size} MB</p>";
    }

    public function save(): bool
    {
        $query = "INSERT INTO products (sku, name, price, type, size) VALUES (:sku, :name, :price, 'DVD', :size)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sku', $this->sku);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':size', $this->size);

    // Check if execution was successful
        if (!$stmt->execute()) {
            error_log("SQL Error in DVD::save(): " . print_r($stmt->errorInfo(), true));
            return false;
        }
        return true;
    }
}
