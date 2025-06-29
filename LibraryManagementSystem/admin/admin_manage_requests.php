<?php
session_start();
include '../includes/db.php';

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all pending requests
$query = "SELECT br.request_id, br.user_id, u.name AS user_name, b.title AS book_title, br.status
          FROM borrow_requests br
          JOIN users u ON br.user_id = u.user_id
          JOIN books b ON br.book_id = b.book_id
          WHERE br.status = 'Pending'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Borrow Requests</title>
    <link rel="stylesheet" href="../assets/css/borrow_requests.css">
    <style>
         .container {
            margin-left: 270px;
            padding: 20px;
            background: white;
            width: 75%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 40px;
            display: flex;
            flex-direction: column;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .accept-btn {
            background-color: green;
            color: white;
        }

        .reject-btn {
            background-color: red;
            color: white;
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

    <div class="container">
        <h2>Manage Borrow Requests</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Book</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sn = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr id='row-{$row['request_id']}'>
                        <td>{$sn}</td>
                        <td>{$row['user_name']}</td>
                        <td>{$row['book_title']}</td>
                        <td class='status'>{$row['status']}</td>
                        <td>
                            <button class='btn accept-btn' onclick='processRequest({$row['request_id']}, \"Approved\", this)'>Accept</button>
                            <button class='btn reject-btn' onclick='processRequest({$row['request_id']}, \"Rejected\", this)'>Reject</button>
                        </td>
                      </tr>";
                $sn++;
            }
            ?>
            </tbody>
        </table>
    </div>

    <script>
        function processRequest(requestId, status, button) {
    if (confirm("Are you sure you want to " + status.toLowerCase() + " this request?")) {
        fetch("admin_process_request.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "request_id=" + requestId + "&status=" + status
        })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Debugging: Log response
            alert(data.message);
            if (data.success) {
                button.closest("tr").remove(); // Remove row from table
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Failed to process request. Check console for details.");
        });
    }
}
    </script>

</body>
</html>
