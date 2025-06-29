<?php
include '../includes/db.php';

// Check if 'id' is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid Book ID!'); window.location.href='view_books.php';</script>";
    exit;
}

$book_id = $_GET['id'];

// Fetch book details with author and category names
$query = "SELECT books.*, 
                 authors.author_id, authors.name AS author_name, 
                 categories.category_id, categories.name AS category_name 
          FROM books
          LEFT JOIN authors ON books.author_id = authors.author_id
          LEFT JOIN categories ON books.category_id = categories.category_id
          WHERE books.book_id = '$book_id'";

$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('Book not found!'); window.location.href='view_books.php';</script>";
    exit;
}

$book = mysqli_fetch_assoc($result);

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_book'])) {
    $new_title = mysqli_real_escape_string($conn, $_POST['title']);
    $new_isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
    $new_category_id = mysqli_real_escape_string($conn, $_POST['category']);
    $new_author_id = mysqli_real_escape_string($conn, $_POST['author']);
    $new_copies = max(0, intval($_POST['available_copies'])); // Ensure available copies do not go below 0

    $update_query = "UPDATE books 
                     SET title = '$new_title', 
                         isbn = '$new_isbn', 
                         category_id = '$new_category_id', 
                         author_id = '$new_author_id', 
                         available_copies = '$new_copies' 
                     WHERE book_id = '$book_id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Book updated successfully!'); window.location.href='view_books.php';</script>";
    } else {
        echo "<script>alert('Error updating book');</script>";
    }
}

// Fetch authors and categories for dropdowns
$authors_result = mysqli_query($conn, "SELECT * FROM authors");
$categories_result = mysqli_query($conn, "SELECT * FROM categories");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Book</title>
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    display: flex;
}

/* Sidebar Styling */
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
    margin-left: 260px; 
    padding: 20px;
    width: calc(100% - 260px);
    /* background: white; */
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Form Styling */
.form-container {
    background-color: white;
    padding: 25px;
    width: 400px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    text-align: center;
}

h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    display: block;
    margin-top: 10px;
    text-align: left;
}

input, select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
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

/* Button Group */
.button-group {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar {
        width: 200px;
    }

    .main-content {
        margin-left: 210px;
        width: calc(100% - 210px);
    }

    .form-container {
        width: 90%;
    }
}

@media (max-width: 500px) {
    .sidebar {
        width: 180px;
    }

    .main-content {
        margin-left: 190px;
        width: calc(100% - 190px);
    }

    .button-group {
        flex-direction: column;
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
        <!-- <h1>Edit Book</h1> -->

        <div class="form-container">
            <h2>Update Book Details</h2>
            <form method="POST">
                <label for="title">Book Title:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>

                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>" required>

                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <?php while ($category = mysqli_fetch_assoc($categories_result)): ?>
                        <option value="<?php echo $category['category_id']; ?>" 
                            <?php echo ($category['category_id'] == $book['category_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="author">Author:</label>
                <select id="author" name="author" required>
                    <?php while ($author = mysqli_fetch_assoc($authors_result)): ?>
                        <option value="<?php echo $author['author_id']; ?>" 
                            <?php echo ($author['author_id'] == $book['author_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($author['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="available_copies">Available Copies:</label>
                <input type="number" id="available_copies" name="available_copies" value="<?php echo $book['available_copies']; ?>" min="0" required>

                <button type="submit" class="update-btn" name="update_book">Update Book</button>
                <a href="view_books.php" class="cancel-btn">Cancel</a>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("edit-book-form");

            form.addEventListener("submit", (event) => {
                if (!confirm("Are you sure you want to update this book?")) {
                    event.preventDefault();
                }
            });
        });

        document.getElementById("available_copies").addEventListener("input", function() {
        if (this.value < 0) {
            this.value = 0; // Reset to 0 if negative
            alert("Available copies cannot be less than 0!");
        }
    });
    </script>
</body>
</html>