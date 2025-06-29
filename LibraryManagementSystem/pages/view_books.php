<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT b.book_id, b.title, 
               IFNULL(a.name, 'Unknown') AS author, 
               IFNULL(c.name, 'Uncategorized') AS category, 
               b.available_copies, b.total_copies 
        FROM books b
        LEFT JOIN authors a ON b.author_id = a.author_id
        LEFT JOIN categories c ON b.category_id = c.category_id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="../assets/css/view_books.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

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
        }

        button {
            padding: 10px 15px;
            background: #2980b9;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            /* margin-left: 10px; */
        }

        button:hover {
            background: #1a5d89;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #2980b9;
            color: white;
        }

        td {
            background: #f4f4f4;
        }

        td:nth-child(4) {
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <h2>Available Books</h2>

    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search for books...">
        <button id="searchBtn">Search</button>
    </div>

    <table id="booksTable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Availability</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo isset($row['author']) ? htmlspecialchars($row['author']) : 'Unknown'; ?></td>
                    <td><?php echo isset($row['category']) ? htmlspecialchars($row['category']) : 'Uncategorized'; ?></td>
                    <td><?php echo ($row['available_copies'] > 0) ? 'Available' : 'Not Available'; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchInput");
        const searchBtn = document.getElementById("searchBtn");
        const tableRows = document.querySelectorAll("#booksTable tbody tr");

        function filterBooks() {
            const query = searchInput.value.toLowerCase();

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? "" : "none";
            });
        }

        searchBtn.addEventListener("click", filterBooks);
        searchInput.addEventListener("keyup", function (event) {
            if (event.key === "Enter") {
                filterBooks();
            }
        });
    });
</script>

</body>
</html>