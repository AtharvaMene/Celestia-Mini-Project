<?php

include 'database.php';
$conn = new mysqli("localhost", "root", "", "celestia");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the email already exists
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        $error = "Email is already registered. Try logging in.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            $success = "Registration successful. <a href='user_login.php'>Login here</a>";
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
    $check_email->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Celestia - User Registration</title>
    <link rel="stylesheet" href="./css/usersignup.css">
    <style>

    </style>
</head>

<body>

    <div class="register-container">
        <h2>Celestia - User Registration</h2>

        <?php
        if (!empty($success)) echo "<p class='message success'>$success</p>";
        if (!empty($error)) echo "<p class='message error'>$error</p>";
        ?>

        <form method="POST">
            <input type="text" name="name" placeholder="Enter your name" required>
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <button type="submit" class="register-btn">Register</button>
        </form>

        <div class="links">
            <a href="user_login.php">Already have an account? Login</a>
        </div>
    </div>

</body>

</html>