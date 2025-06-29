<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch available books
$books_query = "SELECT book_id, title FROM books WHERE available_copies > 0";
$books_result = mysqli_query($conn, $books_query);

if (!$books_result) {
    die("Error fetching books: " . mysqli_error($conn)); // Debugging
}

// Fetch user's borrow requests
$requests_query = "SELECT br.request_id, b.title, br.status 
                   FROM borrow_requests br 
                   JOIN books b ON br.book_id = b.book_id 
                   WHERE br.user_id = '$user_id'";
$requests_result = mysqli_query($conn, $requests_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Request</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

/* Main Container */
.container {
    width: 80%;
    margin-top: 60px;
    margin-left: 280px;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Page Titles */
h2 {
    text-align: center;
    margin-top: 20px;
    margin-bottom: 20px;
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

/* Search Bar */
.search-container {
    text-align: center;
    margin-bottom: 20px;
}

input[type="text"] {
    width: 60%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    display: inline-block;
    font-size: 16px;
}

/* Buttons */
button {
    padding: 10px 15px;
    background: #2980b9;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    transition: 0.3s ease;
}

button:hover {
    background: #1a5d89;
}

/* Table Wrapper for Responsiveness */
.table-container {
    width: 100%;
    overflow-x: auto;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: white;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
    font-size: 16px;
}

/* Table Header */
th {
    background: #2980b9;
    color: white;
    text-transform: uppercase;
}

/* Alternating Row Colors */
td {
    background: #f8f9fa;
    width: 300px;
}

/* Borrow Request Form */
form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background: #f9f9f9;
}

label {
    font-size: 16px;
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

/* Form Select & Button Styling */
select, button {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

button {
    background: #28a745;
    color: white;
    font-size: 16px;
    font-weight: bold;
}

button:hover {
    background: #218838;
}

/* Request Status Styling */
.status {
    font-weight: bold;
    padding: 6px 10px;
    border-radius: 5px;
}

/* Status Colors */
.status-pending {
    background-color: #ffc107;
    color: white;
}

.status-accepted {
    background-color: #28a745;
    color: white;
}

.status-rejected {
    background-color: #dc3545;
    color: white;
}

/* Cancel Button */
.cancel-btn {
    width: 100px;
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 8px 10px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 14px;
    font-weight: bold;
    transition: 0.3s;
    margin: 5px;
}

.cancel-btn:hover {
    background-color: #c0392b;
}

    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="container">
    <h2>Borrow a Book</h2>

    <!-- Borrow Request Form -->
    <form method="POST" action="user_process_borrow_request.php">
        <label>Select a Book:</label>
        <select name="book_id" required>
            <option value="">-- Choose a book --</option>
            <?php 
            while ($book = mysqli_fetch_assoc($books_result)) { 
                echo "<option value='{$book['book_id']}'>" . htmlspecialchars($book['title']) . "</option>";
            }
            ?>
        </select>
        <button type="submit">Request Book</button>
    </form>

    <!-- My Borrow Requests -->
    <h2>My Borrow Requests</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Status</th>
                    <!-- <th>Action</th> -->
                </tr>
            </thead>
            <tbody>
                <?php while ($request = mysqli_fetch_assoc($requests_result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($request['title']); ?></td>
                        <td class="status <?php echo strtolower($request['status']); ?>">
                            <?php echo htmlspecialchars($request['status']); ?>
                        </td>
                        <!-- <td>
                <?php if ($request['status'] === 'Pending' || 'rejected') { ?>
                    <button class="cancel-btn" data-request-id="<?php echo $request['request_id']; ?>">Cancel</button>
                <?php } else { ?>
                    <span>-</span>
                <?php } ?>
            </td> -->
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const cancelButtons = document.querySelectorAll(".cancel-btn");

    cancelButtons.forEach(button => {
        button.addEventListener("click", function() {
            const requestId = this.dataset.requestId;
            if (confirm("Are you sure you want to cancel this request?")) {
                fetch("user_cancel_request.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "request_id=" + requestId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Request canceled successfully!");
                        location.reload();
                    } else {
                        alert("Failed to cancel request.");
                    }
                });
            }
        });
    });
});
</script>
</body>
</html>