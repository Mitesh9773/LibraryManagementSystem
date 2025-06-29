<?php
include '../includes/db.php';

// Check if 'id' is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid Author ID!'); window.location.href='add_authors.php';</script>";
    exit;
}

$author_id = $_GET['id'];

// Fetch author details
$query = "SELECT * FROM authors WHERE author_id = '$author_id'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('Author not found!'); window.location.href='add_authors.php';</script>";
    exit;
}

$author = mysqli_fetch_assoc($result);

// Handle updating the author
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_author'])) {
    $new_author_name = mysqli_real_escape_string($conn, $_POST['author_name']);

    if (!empty($new_author_name)) {
        $update_query = "UPDATE authors SET name = '$new_author_name' WHERE author_id = '$author_id'";
        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('Author updated successfully!'); window.location.href='add_authors.php';</script>";
        } else {
            echo "<script>alert('Error updating author');</script>";
        }
    } else {
        echo "<script>alert('Author name cannot be empty!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Author</title>
    <link rel="stylesheet" href="../assets/css/manage_authors.css">
    <style>
        
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

/* Sidebar */
.sidebar {
    width: 210px;
    background: #222;
    color: white;
    height: 100vh;
    padding-top: 20px;
    position: fixed;
    left: 0;
    top: 0;
    overflow-y: auto;
}

.sidebar h2 {
    text-align: center;
    margin-bottom: 25px;
}

.sidebar ul {
    
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    padding: 10px 0px;
    border-bottom: 1px solid #333;
}

.sidebar ul li a {
    color: white;
    text-decoration: none;
    display: block;
}

.sidebar ul li:hover {
    background: #444;
}

/* Main Content */
.main-content {
    margin-left: 270px;
    padding: 20px;
    text-align: center;
}

/* Container for form and table */
.container {
    display: flex;
    justify-content: space-between;
    max-width: 1000px;
    margin: 0 auto;
}

/* Form Container */
.form-container {
    width: 40%;
    background: white;
    padding: 20px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    margin-right: 20px;
    margin-left: -20px;
}

.form-container h2 {
    text-align: center;
}

.form-container input {
    width: 95%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}
button {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    margin-top: 15px;
    cursor: pointer;
    border-radius: 5px;
    border: none;
    background-color:  #1db8f8;
    color: white;
}

.update-btn:hover {
    background-color: #009fe1;
}

.cancel-btn {
    width: 95%;
    margin-top: 10px;
    padding: 10px;
    display: inline-block;
    text-align: center;
    background: red;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}
.cancel-btn {
    background-color:rgb(239, 59, 77);
    color: white;
}

.cancel-btn:hover {
    background-color: #c82333;
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
        <h1></h1>
        
        <div class="form-container">
            <h2>Update Author Details</h2>
            <form method="POST">
                <label for="author_name">Author Name:</label>
                <input type="text" id="author_name" name="author_name" value="<?php echo htmlspecialchars($author['name']); ?>" required>
                <button type="submit" name="update_author">Update Author</button>
                <a href="add_authors.php" class="cancel-btn">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
