<?php

use App\Classes\Database;
use App\Classes\ProductRepository;

$db = (new Database())->getConnection();
$productRepository = new ProductRepository($db);

$products = $productRepository->getAllProducts();
