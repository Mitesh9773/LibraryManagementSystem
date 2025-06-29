<?php
include '../includes/db.php';

// Initialize category array
$category = null;

// Fetch category details securely
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $category_id = $_GET['id'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM categories WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
    } else {
        echo "<script>alert('Error: Category not found.'); window.location.href = 'add_categories.php';</script>";
        exit();
    }
}

// Handle category update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_category'])) {
    $category_id = $_POST['category_id'];
    $category_name = trim($_POST['category_name']);

    if (!empty($category_name)) {
        $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE category_id = ?");
        $stmt->bind_param("si", $category_name, $category_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Category updated successfully!'); window.location.href = 'add_categories.php';</script>";
        } else {
            echo "<script>alert('Error updating category.');</script>";
        }
    } else {
        echo "<script>alert('Category name cannot be empty!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link rel="stylesheet" href="../assets/css/manage_categories.css">
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
        <h1>Edit Category</h1>

        <div class="container">
            <div class="form-container">
                <h2>Update Category</h2>
                <form method="POST">
                    <input type="hidden" name="category_id"
                        value="<?php echo htmlspecialchars($category['category_id'] ?? ''); ?>">

                    <label for="category_name">Category Name:</label>
                    <input type="text" id="category_name" name="category_name" 
                        value="<?php echo htmlspecialchars($category['name'] ?? ''); ?>" min="0" required>

                    <div class="action-buttons">
                        <button type="submit" name="update_category" class="update-btn">Update</button>
                        <a href="add_categories.php" class="cancel-btn">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>