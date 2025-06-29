<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['issue_id'])) {
    $issue_id = $_POST['issue_id'];

    // Update return status
    $query = "UPDATE issued_books SET return_status = 'Returned' WHERE issue_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $issue_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Book returned successfully!";
    } else {
        $_SESSION['error_message'] = "Error returning the book: " . $stmt->error;
    }

    // Redirect back to issued_books.php
    header("Location: issued_books.php");
    exit();
} else {
    $_SESSION['error_message'] = "Invalid request.";
    header("Location: issued_books.php");
    exit();
}
?>
