<?php

namespace App\Classes;

use App\Classes\Product;

class Book extends Product
{
    private float $weight;

    public function __construct(string $sku, string $name, float $price, array $attributes)
    {
        parent::__construct($sku, $name, $price);
        $this->weight = $attributes['weight'];
    }

    public function displaySpecificDetails(): void
    {
        echo "<p>Weight: {$this->weight} Kg</p>";
    }

    public function save(): bool
    {
        $query = "INSERT INTO products (sku, name, price, type, weight) VALUES (:sku, :name, :price, 'Book', :weight)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sku', $this->sku);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':weight', $this->weight);

        return $stmt->execute();
    }
}
