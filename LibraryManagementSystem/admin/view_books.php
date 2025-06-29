<?php
include '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="../assets/css/view_books.css">
    <script defer src="../assets/js/view_books.js"></script>
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
        
        <div class="table-container">
            <h2>List of Books</h2>
            <table>
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>ISBN</th>
                        <th>Book Name</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch books with correct aliases
                    $query = "SELECT books.*, 
                                     authors.name AS author_name, 
                                     categories.name AS category_name 
                              FROM books
                              LEFT JOIN authors ON books.author_id = authors.author_id
                              LEFT JOIN categories ON books.category_id = categories.category_id";
                    
                    $result = mysqli_query($conn, $query);
                    $sn = 1;
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$sn}</td>
                                <td>{$row['isbn']}</td>
                                <td>{$row['title']}</td>
                                <td>{$row['category_name']}</td>
                                <td>{$row['author_name']}</td>
                                <td>{$row['available_copies']}</td>
                                <td>
                                    <a href='manage_book.php?id={$row['book_id']}' class='edit-btn'>Edit</a>
                                    <button class='delete-btn' data-id='{$row['book_id']}'>Delete</button>
                                </td>
                              </tr>";
                        $sn++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
