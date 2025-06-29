<?php
include '../config.php'; // Include database connection
session_start();

// Handle book addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['book_title']);
    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $available_copies = mysqli_real_escape_string($conn, $_POST['available_copies']);

    $query = "INSERT INTO books (title, isbn, category_id, author_id, available_copies) 
              VALUES ('$title', '$isbn', '$category', '$author', '$available_copies')";  
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Book added successfully!'); window.location.href='view_books.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Book</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
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
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px 20px;
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
        }

        .main-content h1 {
            font-size: 28px;
            margin-left: 25px;
            margin-bottom: 20px;
        }

        /* Form Container */
        .form-container {
            background-color: white;
            margin: 20px;
            padding: 30px;
            width: 400px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .form-container h2 {
            font-size: 22px;
            text-align: center;
            margin-bottom: 15px;
        }

        .form-container label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        .form-container input,
        .form-container select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            font-size: 16px;
            margin-top: 15px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .form-container button:hover {
            background-color: #218838;
        }

        /* Responsive */
        @media screen and (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .form-container {
                width: 100%;
            }
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
    <h1>Add a Book</h1>

    <div class="form-container">
        <h2>Add a Book</h2>
        <form action="add_book.php" method="POST">
            <label for="book_title">Book Title:</label>
            <input type="text" id="book_title" name="book_title" required>

            <label for="isbn">ISBN Number:</label>
            <input type="text" id="isbn" name="isbn" required>

            <label for="category">Select Category:</label>
            <select id="category" name="category" required>
                <option value="">-Select Category-</option>
                <?php
                $cat_query = mysqli_query($conn, "SELECT * FROM categories");
                while ($row = mysqli_fetch_assoc($cat_query)) {
                    echo "<option value='" . $row['category_id'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select>

            <label for="author">Select Author:</label>
            <select id="author" name="author" required>
                <option value="">-Select Author-</option>
                <?php
                $author_query = mysqli_query($conn, "SELECT * FROM authors");
                while ($row = mysqli_fetch_assoc($author_query)) {
                    echo "<option value='" . $row['author_id'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select>

            <label for="available_copies">Available Copies:</label>
            <input type="number" id="available_copies" name="available_copies" required>

            <button type="submit">Add Book</button>
        </form>
    </div>
</div>

</body>
</html>
