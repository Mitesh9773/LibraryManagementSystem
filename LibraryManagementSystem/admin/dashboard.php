<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}

include "../includes/db.php"; // Database connection

// Fetch total counts
$book_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM books"))['total'];
$category_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM categories"))['total'];
$author_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM authors"))['total'];
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            }
    </style>
</head>
<body>

<div class="container">
    <aside class="sidebar">
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
    </aside>

    <main class="main-content">
        <h1>Admin Dashboard</h1>

        <div class="dashboard-stats">
            <div class="stat-box">
                <p>No. of Books</p>
                <h3>Total Books: <?php echo $book_count; ?></h3>
            </div>
            <div class="stat-box">
                <p>No. of Categories</p>
                <h3>Total Categories: <?php echo $category_count; ?></h3>
            </div>
            <div class="stat-box">
                <p>No. of Authors</p>
                <h3>Total Authors: <?php echo $author_count; ?></h3>
            </div>
            <div class="stat-box">
                <p>No. of Users</p>
                <h3>Total Users: <?php echo $user_count; ?></h3>
            </div>
        </div>

        <section class="info-section">
            <h2>Things to keep in mind</h2>
            <ul>
                <li>Books are issued for 15 days. Users must return them on time to avoid fines.</li>
                <li> A fine of ₹10 per day is charged after the due date period.</te
            </ul>
        </section>
    </main>
</div>

<script src="../assets/js/dashboard.js"></script>
</body>
</html>