<?php include '../includes/header.php'; ?>
<?php include "../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt password
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

    $query = "INSERT INTO users (name, email, password, mobile) VALUES ('$name', '$email', '$password', '$mobile')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: login.php?message=registered");
        exit();
    } else {
        $error = "Registration failed. Try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="../assets/CSS/reg.css">
</head>
<body>
    <div class="auth-container">
        <h2>User Registration</h2>
        <form method="POST">
            <label for="name">Full Name</label>
            <input type="text" name="name" placeholder="Full Name" required>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Password" required>
            <label for="mobile">Mobile Number:</label>
            <input type="text" name="mobile" placeholder="Mobile Number" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
