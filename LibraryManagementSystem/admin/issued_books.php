<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT ib.issue_id, b.title AS book_title, ib.issue_date, ib.due_date, ib.return_status, 
                 u.name AS user_name, 
                 COALESCE(f.amount, 0) AS fine_amount, 
                 COALESCE(f.status, 'No Fine') AS fine_status
          FROM issued_books ib
          JOIN books b ON ib.book_id = b.book_id
          JOIN users u ON ib.user_id = u.user_id
          LEFT JOIN fines f ON ib.issue_id = f.issue_id
          WHERE ib.return_status IN ('Issued', 'Returned')";  // Fetch both issued and returned books

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$issued_books = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issued Books</title>
    <link rel="stylesheet" href="../assets/css/issued_books.css">
    <style>
        .main-content {
    max-width: 1040px;
    margin-left: 350px;
    padding: 32px;
    text-align: center;
    margin-top: 40px;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
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
        <h1>Issued Books</h1>
        <div class="table-container">
                    <?php
            if (isset($_SESSION['success_message'])) {
                echo "<p style='color: green; text-align: center;'>" . $_SESSION['success_message'] . "</p>";
                unset($_SESSION['success_message']);
            } elseif (isset($_SESSION['error_message'])) {
                echo "<p style='color: red; text-align: center;'>" . $_SESSION['error_message'] . "</p>";
                unset($_SESSION['error_message']);
            }
            ?>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User Name</th>
                        <th>Book Title</th>
                        <th>Issue Date</th>
                        <th>Due Date</th>
                        <th>Return Status</th>
                        <th>Fine Amount</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    $sn = 1;
    foreach ($issued_books as $book) {
        $return_button = "";
        if ($book['return_status'] === 'Issued') {
            $return_button = "
    <form action='return_book.php' method='POST'>
        <input type='hidden' name='issue_id' value='{$book['issue_id']}'>
        <button type='submit' class='return-btn'>Return</button>
    </form>";
        }

        echo "<tr>
                <td>{$sn}</td>
                <td>{$book['user_name']}</td>
                <td>{$book['book_title']}</td>
                <td>{$book['issue_date']}</td>
                <td>{$book['due_date']}</td>
                <td>" . ucfirst($book['return_status']) . "</td>
                <td>₹" . $book['fine_amount'] . "</td>
                <td>" . ucfirst($book['fine_status']) . "</td>
                <td>{$return_button}</td>
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
