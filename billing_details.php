<?php
include 'database.php';
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize user input
    $full_name = trim($_POST['full_name']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $pincode = trim($_POST['pincode']);
    $phone = trim($_POST['phone']);

    if (!empty($full_name) && !empty($address) && !empty($city) && !empty($pincode) && !empty($phone)) {
        // Insert billing details into database
        $stmt = $conn->prepare("INSERT INTO billing_details (user_id, full_name, address, city, pincode, phone) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssis", $user_id, $full_name, $address, $city, $pincode, $phone);

        if ($stmt->execute()) {
            $success = "Billing details saved successfully!";
            // Optionally redirect to checkout or show confirmation
            header("Location: checkout.php");
            exit;
        } else {
            $error = "Error saving billing details. Please try again.";
        }

        $stmt->close();
    } else {
        $error = "Please fill in all the required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Billing Details</title>
    <link rel="stylesheet" href="./css/billing.css">
</head>
<body>

    <h2>Billing Details</h2>

    <?php if ($success): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php elseif ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="billing_details.php" method="POST" class="billing-form">
        <label for="full_name">Full Name:</label><br>
        <input type="text" id="full_name" name="full_name" required><br><br>

        <label for="address">Address:</label><br>
        <textarea id="address" name="address" rows="4" required></textarea><br><br>

        <label for="city">City:</label><br>
        <input type="text" id="city" name="city" required><br><br>

        <label for="pincode">Pincode:</label><br>
        <input type="text" id="pincode" name="pincode" required><br><br>

        <label for="phone">Phone Number:</label><br>
        <input type="text" id="phone" name="phone" required><br><br>

        <button type="submit" class="submit-btn">Save & Continue</button>
    </form>

</body>
</html>
