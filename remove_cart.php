<?php
include 'database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: user_login.php");
    exit;
}

// Proceed with the removal if user is logged in
$conn = new mysqli('localhost', 'root', '', 'celestia');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user ID and product ID from the URL
$user_id = $_SESSION['user_id'];
$product_id = $_GET['product_id'];

// Delete the product from the cart
$sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();

// Redirect back to the cart page after removal
header("Location: cart.php");
exit;
?>

<?php
$stmt->close();
$conn->close();
?>
