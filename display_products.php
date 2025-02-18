<?php
include 'database.php';
session_start();

// Redirect to login page if admin is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: adminLogin.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'celestia');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle product deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_page.php"); // Refresh the page after deletion
    exit();
}

// Fetch all products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Celestia - Admin Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
            background-color: #f8f8f8;
        }

        .mainContainer {
            padding: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            max-width: 400px;
            margin: 0 auto 20px;
        }

        .addbutton, .logout-btn {
            background-color: #4CAF50;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            color: white;
            text-decoration: none;
        }

        .addbutton a {
            color: white;
            text-decoration: none;
        }

        .addbutton:hover {
            background-color: #45a049;
        }

        .logout-btn {
            background-color: #ff4d4d;
        }

        .logout-btn:hover {
            background-color: #cc0000;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }

        .product {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 15px;
            margin: 10px;
            width: 250px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .product img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            border-radius: 5px;
        }

        .product h3 {
            margin: 10px 0;
            color: #333;
        }

        .product p {
            font-size: 14px;
            color: #666;
        }

        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: auto;
        }

        .delete-btn:hover {
            background-color: darkred;
        }
    </style>
</head>

<body>
    <div class="mainContainer">
        <h1>Admin Page - Celestia</h1>

        <!-- Add & Logout Buttons -->
        <div class="buttons">
            <button class="addbutton"><a href="add_product.php">➕ Add Products</a></button>
            <button class="logout-btn" onclick="window.location.href='?logout=true'">🚪 Logout</button>
        </div>

        <div class="product-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<img src='images/" . $row['imageUrl'] . "' alt='Product Image'>";
                    echo "<h3>" . $row['name'] . "</h3>";
                    echo "<p>" . $row['description'] . "</p>";
                    echo "<p><strong>Price: ₹" . $row['price'] . "</strong></p>";
                    echo "<form action='' method='POST'>";
                    echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' class='delete-btn'>🗑 Delete</button>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "<p>No products found.</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>

<?php
// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: user_login.php");
    exit();
}
?>
