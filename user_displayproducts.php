<?php
include 'database.php';
session_start();
$conn = new mysqli("localhost", "root", "", "celestia");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, price, imageUrl FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Celestia Products</title>
    <link rel="stylesheet" href="./css/userdisplayproductspage.css">
    <style>

    </style>
</head>

<body>

    <div class="navbar">
        <a href="celestia.php" style="font-weight: bold;">Celestia</a>
        <div class="nav-links">
            <a href="#">Skin Care</a>
            <a href="#">Makeup</a>
            <a href="#">Hair</a>
            <a href="#">Body</a>
        </div>
        <div>
            <a href="cart.php">View Cart</a>
            <a href="user_login.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <h2 style="text-align:center; color:#a83279; margin-top:20px;">Our Products</h2>

    <div class="categories">
        <div class="category">Skin Care</div>
        <div class="category">Makeup</div>
        <div class="category">Beauty Advice</div>
        <div class="category">Celestia Premium</div>
    </div>

    <div class="userproductcontainer">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product'>
                        <img src='images/" . $row['imageUrl'] . "' alt='" . $row['name'] . "'>
                        <h3>" . $row['name'] . "</h3>
                        <p>₹" . $row['price'] . "</p>
                        <form action='cart.php' method='POST'>
                            <input type='hidden' name='product_id' value='" . $row['id'] . "'>
                            <button type='submit' class='add-to-cart-btn'> Add to Cart</button>
                        </form>
                      </div>";
            }
        } else {
            echo "<p style='text-align:center;'>No products available.</p>";
        }
        ?>
    </div>

</body>

</html>

<?php $conn->close(); ?>