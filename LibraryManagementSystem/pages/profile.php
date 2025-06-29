<?php
session_start();
include "../includes/db.php"; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$query = "SELECT name, email, mobile FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $mobile);
$stmt->fetch();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = $_POST['name'];
    $new_mobile = $_POST['mobile'];

    // Update user details in the database
    $updateQuery = "UPDATE users SET name = ?, mobile = ? WHERE user_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ssi", $new_name, $new_mobile, $user_id);

    if ($updateStmt->execute()) {
        $message = "Profile updated successfully!";
        $name = $new_name;
        $mobile = $new_mobile;
    } else {
        $message = "Error updating profile!";
    }
    $updateStmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>
<?php include 'sidebar.php'; ?>
    <div class="container">
        <h2>Update Profile</h2>
        <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>
        <form method="post" onsubmit="return validateProfileForm()">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" value="<?php echo htmlspecialchars($email); ?>" disabled>

            <label for="mobile">Mobile:</label>
            <input type="text" id="mobile" name="mobile" value="<?php echo htmlspecialchars($mobile); ?>" required>

            <button type="submit">Update</button>
        </form>
    </div>

    <script src="../assets/js/profile.js"></script>
</body>
</html>
