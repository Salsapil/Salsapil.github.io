<?php

namespace App\Classes;

use App\Classes\Database;

abstract class Product
{
    protected string $sku;
    protected string $name;
    protected float $price;
    protected \PDO $db;

    public function __construct(string $sku, string $name, float $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->db = (new Database())->getConnection(); // Database connection is set up in the constructor
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function displayCommonDetails(): void
    {
        echo "<p>SKU: {$this->sku}</p>";
        echo "<p>Name: {$this->name}</p>";
        echo "<p>Price: \${$this->price}</p>";
    }

    abstract public function displaySpecificDetails(): void;

    abstract public function save(): bool;
}
