<?php include '../includes/header.php'; ?>
<?php
session_start();
include "../includes/db.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Fetch admin details
    $query = "SELECT * FROM admin WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        
        // Verify password
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['email'] = $admin['email'];
            header("Location: dashboard.php"); // Redirect to Admin Dashboard
            exit();
        } else {
            $error = "Invalid email or password!";
        }
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        
        <link rel="stylesheet" href="../assets/CSS/style.css">
        <style>
            button {
                margin-top: 10px;
                width: 97%;
                padding: 12px;
                background: #333;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }

            button:hover {
                background-color:rgba(0, 0, 0, 0.92);
                color:white;
            }
        </style>
        <!-- Link to CSS file -->
    </head>
    <body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="POST">
            <label>Email:</label>
            <input type="email" name="email" placeholder="Email" required>

            <label>Password:</label>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Login</button>
        </form>
    </div>
    <script defer src="../assets/js/script.js"></script>
</body>
</html>