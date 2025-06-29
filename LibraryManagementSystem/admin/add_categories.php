<?php
include '../includes/db.php';

// Handle adding a new category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_category'])) {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);

    if (!empty($category_name)) {
        $query = "INSERT INTO categories (name) VALUES ('$category_name')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Category added successfully!'); window.location.href='manage_categories.php';</script>";
        } else {
            echo "<script>alert('Error adding category');</script>";
        }
    } else {
        echo "<script>alert('Category name cannot be empty!');</script>";
    }
}

// Handle deleting a category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_category'])) {
    $category_id = $_POST['category_id'];
    $query = "DELETE FROM categories WHERE category_id = '$category_id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Category deleted successfully!'); window.location.href='manage_categories.php';</script>";
    } else {
        echo "<script>alert('Error deleting category');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="../assets/css/categories.css">
    <style>
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

.add-btn {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.add-btn:hover {
    background-color: #218838;
}

/* Table Container */
.table-container {
    width: 55%;
    background: white;
    padding: 20px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.table-container h2 {
    text-align: center;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

th, td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background: #f4f4f4;
}
        /* Button Container */
        .action-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            /* Space between buttons */
        }

        /* Edit & Delete Buttons */
        .edit-btn,
        .delete-btn {
            padding: 3px 8px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            width: 75px;
            /* Same width */
            height: 30px;
            /* Same height */
            text-align: center;
            line-height: 30px;
        }

        .edit-btn {
            background-color: #007bff;
            color: white;
        }

        .edit-btn {
            padding:4px 0px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            width: 70px;
            /* Same width */
            height: 30px;
            /* Same height */
            text-align: center;
            line-height: 30px;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .delete-btn {
            padding: 5px 10px;
            width: 70px;
            height: 38px;

        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }
        .edit-btn:hover {
            background-color: #0056b3;
        }

        .delete-btn:hover {
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
        <h1>Manage Categories</h1>

        <div class="container">
            <!-- Add Category Form -->
            <div class="form-container">
                <h2>Add Category</h2>
                <form id="add-category-form" method="POST">
                    <!-- <label for="category_name">Category Name:</label> -->
                    <input type="text" id="category_name" name="category_name" placeholder="Enter Category Name" required>
                    <button type="submit" name="add_category">Add Category</button>
                </form>
            </div>

            <!-- Category List -->
            <div class="table-container">
                <h2>List of Categories</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM categories";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['category_id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>
                                        <div class='action-buttons'>
                                            <a href='manage_categories.php?id={$row['category_id']}' class='edit-btn'>Edit</a>
                                            <form method='POST' class='delete-form'>
                                                <input type='hidden' name='category_id' value='{$row['category_id']}'>
                                                <button type='submit' name='delete_category' class='delete-btn'>Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
