<div class="container">
    <header>
        <h1>Product List</h1>
        <div class="actions">
            <a href="/views/add_products.php" class="btn">ADD</a>
            <button id="delete-product-btn" class="btn">MASS DELETE</button>
        </div>
    </header>
    <hr>
    <div class="product-grid">
        <?php
        require_once __DIR__ . '/../controllers/product_list.php';

        foreach ($products as $product) {
            echo '<div class="product-item">';
            echo '<input type="checkbox" class="delete-checkbox" value="' . $product->getSku() . '">';
            $product->displayCommonDetails();
            $product->displaySpecificDetails();
            echo '</div>';
        }
        ?>
    </div>
</div>

<link rel="stylesheet" href="/assets/css/style.css">
<script src="/assets/js/app.js"></script>
<script src="/assets/js/delete.js"></script>
