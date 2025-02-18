<?php
include 'database.php';
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'celestia');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$price = $_POST['price'];
$description = $_POST['description'];
$imageUrl = $_POST['imageUrl'];

// Insert into database
$sql = "INSERT INTO products (name, price, description, imageUrl) VALUES ('$name', '$price', '$description', '$imageUrl')";

if ($conn->query($sql) === TRUE) {  
    echo "<script>
            alert('Product Successfully Added');
            window.location.href = 'display_products.php';
          </script>";
} else {
    echo "Error: " . $conn->error;
}

// Close the connection
$conn->close();
