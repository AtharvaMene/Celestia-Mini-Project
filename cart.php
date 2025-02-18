<?php

include 'database.php';
session_start();
$conn = new mysqli('localhost', 'root', '', 'celestia');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// ✅ Handle "Add to Cart" logic (Prevent duplicates)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id']) && !isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];

    // Check if product is already in cart
    $stmt = $conn->prepare("SELECT 1 FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert only if the product is not already in the cart
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    }

    $stmt->close();
    header("Location: cart.php");
    exit;
}

// ✅ Handle "Remove from Cart" logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id']) && isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $stmt->close();

    // Refresh the cart page after removing
    header("Location: cart.php");
    exit;
}

// ✅ Fetch cart items
$sql = "SELECT products.name, products.price, products.id AS product_id, products.imageUrl
        FROM cart
        JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="./css/cart.css">
</head>

<body>

    <h2>Your Cart</h2>

    <div class="cart-container">
        <table>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td><img class='cart-img' src='images/" . $row['imageUrl'] . "' alt='" . $row['name'] . "'></td>
                            <td>" . $row['name'] . "</td>
                            <td>₹" . $row['price'] . "</td>
                            <td>
                                <form method='POST' action='cart.php'>
                                    <input type='hidden' name='product_id' value='" . $row['product_id'] . "'>
                                    <button type='submit' name='remove' class='remove-btn'>Remove</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Your cart is empty.</td></tr>";
            }
            ?>
        </table>

        <button class="add-more-btn" onclick="window.location.href='user_displayproducts.php'">Add More Products</button>
        <button class="checkout-btn" onclick="window.location.href='checkout.php'">Checkout</button>
    </div>

</body>

</html>

<?php
$stmt->close();
$conn->close();
?>