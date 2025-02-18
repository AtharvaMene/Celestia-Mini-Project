<?php

include 'database.php';
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'celestia');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the product ID from the form
$product_id = $_POST['product_id'];

// Delete the product from the database
$sql = "DELETE FROM products WHERE id = $product_id";

if ($conn->query($sql) === TRUE) {
    header("Location: display_products.php");
} else {
    echo "Error deleting product: " . $conn->error;
}

$conn->close();
?>
<a href="display_products.php">Go Back</a>