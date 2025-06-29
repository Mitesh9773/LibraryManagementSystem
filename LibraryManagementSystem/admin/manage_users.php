<?php
include '../includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../assets/css/manage_users.css">
    <script defer src="../assets/js/manage_users.js"></script>
</head>
<body>

    <!-- Sidebar -->
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

    <!-- Main Content -->
    <div class="main-content">
        <h2>List of Users</h2>

        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT user_id, name, email, mobile FROM users";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['user_id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['mobile']}</td>
                            <td>
                                <a href='user_edit.php?id={$row['user_id']}' class='edit-btn'>Edit</a>
                                <button class='delete-btn' data-id='{$row['user_id']}'>Delete</button>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".delete-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let userId = this.getAttribute("data-id");
                    if (confirm("Are you sure you want to delete this user?")) {
                        window.location.href = `delete_user.php?id=${userId}`;
                    }
                });
            });
        });
    </script>

</body>
</html>
