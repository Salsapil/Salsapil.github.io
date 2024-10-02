<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../assets/css/add_style.css">
    <script src="../assets/js/dynamic_form.js" defer></script>
</head>
<body>
<div class="container">
    <header>
        <h1>Product Add</h1>
        <div class="actions">
            <button id="save" class="btn" type="submit" form="product_form">Save</button>
            <button class="btn" type="button" onclick="window.location.href='../index.php'">Cancel</button>
        </div>
    </header>
    <hr>
    <form id="product_form" method="POST">
        <label for="sku">SKU</label>
        <input type="text" id="sku" name="sku" required><br>

        <label for="name">Name</label>
        <input type="text" id="name" name="name" required><br>

        <label for="price">Price ($)</label>
        <input id="price" name="price" required><br>

        <label for="productType">Type Switcher</label>
        <select id="productType" name="productType" required>
            <option value="">Select Type</option>
            <option value="DVD" id="DVD">DVD</option>
            <option value="Book" id="Book">Book</option>
            <option value="Furniture" id="Furniture">Furniture</option>
        </select><br>

        <!-- DVD specific attributes -->
        <div id="dvdAttributes" class="product-attributes" style="display: none;">
            <label for="size">Size (MB)</label>
            <input id="size" name="size" required>
            <p>Please, provide size</p>
        </div>

        <!-- Book specific attributes -->
        <div id="bookAttributes" class="product-attributes" style="display: none;">
            <label for="weight">Weight (Kg)</label>
            <input id="weight" name="weight" required>
            <p>Please, provide weight</p>
        </div>

        <!-- Furniture specific attributes -->
        <div id="furnitureAttributes" class="product-attributes" style="display: none;">
            <label for="height">Height (CM)</label>
            <input id="height" name="height" required><br>

            <label for="width">Width (CM)</label>
            <input id="width" name="width" required><br>

            <label for="length">Length (CM)</label>
            <input id="length" name="length" required><br>
            <p>Please, provide dimensions</p>
        </div>

        <div id="notification" style="color: red; display: none;"></div>
    </form>
</div>
</body>
</html>
