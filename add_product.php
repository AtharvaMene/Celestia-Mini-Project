<?php
include 'database.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="./css/addproducts.css">
</head>

<body>
    <h2>Add Product</h2>
    <form action="save_product.php" method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" required><br>

        <label>Price:</label><br>
        <input type="number" name="price" required><br>

        <label>Description:</label><br>
        <textarea name="description" required></textarea><br>

        <label>Image URL:</label><br>
        <input type="text" name="imageUrl" placeholder="Enter image URL" required><br><br>

        <button type="submit">Save Product</button>
    </form>

    <br>
    <a href="./display_products.php">View Products</a>
</body>

</html>