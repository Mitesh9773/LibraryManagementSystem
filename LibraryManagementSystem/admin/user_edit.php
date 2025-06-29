<?php
include '../includes/db.php';

// Check if 'id' is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid User ID!'); window.location.href='manage_users.php';</script>";
    exit;
}

$user_id = $_GET['id'];

// Fetch user details
$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('User not found!'); window.location.href='manage_users.php';</script>";
    exit;
}

$user = mysqli_fetch_assoc($result);

// Handle updating the user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    $new_name = mysqli_real_escape_string($conn, $_POST['name']);
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

    if (!empty($new_name) && !empty($new_email) && !empty($new_mobile)) {
        $update_query = "UPDATE users SET name = '$new_name', email = '$new_email', mobile = '$new_mobile' WHERE user_id = '$user_id'";
        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('User updated successfully!'); window.location.href='manage_users.php';</script>";
        } else {
            echo "<script>alert('Error updating user');</script>";
        }
    } else {
        echo "<script>alert('All fields are required!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="../assets/css/user_edit.css">
    <script defer src="../assets/js/user_edit.js"></script>
    <style>

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 90%;
}

    .button-group {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.main-content {
    margin-top:100px;
    margin-left: 260px;
    padding: 20px;
    width: 400px;
    background: white;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    text-align: center;
}
</style>
</head>
<body>
    <div class="sidebar">
        <h2>LMS</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="add_book.php">Add a Book</a></li>
            <li><a href="view_books.php">View Books</a></li>
            <li><a href="add_authors.php">Manage Authors</a></li>
            <li><a href="add_categories.php">Manage Categories</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="admin_manage_requests.php">Borrow Requests</a></li>
            <li><a href="issued_books.php">Issued Books</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h2>Edit User Details</h2>
        <form method="POST" id="editUserForm">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="mobile">Mobile:</label>
            <input type="text" id="mobile" name="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>" required>

            <div class="button-group">
                <button type="submit" name="update_user" class="update-btn">Update User</button>
                <a href="manage_users.php" class="cancel-btn">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
