<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

include "../includes/db.php"; 

$user_id = $_SESSION['user_id'];

// Check column name in your database and update accordingly
$query = "SELECT name, email, mobile FROM users WHERE user_id = '$user_id'"; 

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query Failed: " . mysqli_error($conn)); // Debugging step
}

$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .main-content {
    flex-grow: 1;
    padding: 20px;
    background: white;
}

h1 {
    margin-bottom: 20px;
}

h2{
    text-align:center;
    
}
.profile-section {
    width: 400px;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 2px 2px 7px 2px hsl(0deg 0% 0% / 16%);
    margin-left: 250px;
}

.profile-section table {
    width: 100%;
    border-collapse: collapse;
}

.profile-section table td {
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

.profile-section table td:first-child {
    font-weight: bold;
}
    </style>
</head>
<body>

<div class="container">
    <aside class="sidebar">
        <h2>LMS</h2>
        <ul>
            <li><a href="user_dashboard.php">Dashboard</a></li>
            <li><a href="profile.php">Update Profile</a></li>
            <li><a href="view_books.php">View Available Books</a></li>
            <li><a href="borrow_request.php">Borrow Request</a></li>
            <li><a href="issued_books.php">Issued Books</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <h1>User Dashboard</h1>

        <section class="profile-section">
            <h2>User Profile</h2>
            <table>
                <tr>
                    <td><strong>Name:</strong></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
                <tr>
                    <td><strong>Mobile:</strong></td>
                    <td><?php echo htmlspecialchars($user['mobile']); ?></td>
                </tr>
            </table>
        </section>
    </main>
</div>

</body>
</html>
