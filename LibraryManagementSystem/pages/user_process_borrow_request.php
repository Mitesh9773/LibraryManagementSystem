<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if book_id is sent
if (!isset($_POST['book_id']) || empty($_POST['book_id'])) {
    die("Invalid book request.");
}

$book_id = intval($_POST['book_id']); // Ensure it's an integer

// Check if book exists and is available
$book_query = "SELECT available_copies FROM books WHERE book_id = ?";
$stmt = mysqli_prepare($conn, $book_query);
mysqli_stmt_bind_param($stmt, "i", $book_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$book = mysqli_fetch_assoc($result);

if (!$book || $book['available_copies'] <= 0) {
    die("Book is not available.");
}

// Check if the user already requested this book
$request_check_query = "SELECT * FROM borrow_requests WHERE user_id = ? AND book_id = ? AND status = 'Pending'";
$stmt = mysqli_prepare($conn, $request_check_query);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $book_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    die("You have already requested this book.");
}

// Insert borrow request
$insert_query = "INSERT INTO borrow_requests (user_id, book_id, status) VALUES (?, ?, 'Pending')";
$stmt = mysqli_prepare($conn, $insert_query);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $book_id);

if (mysqli_stmt_execute($stmt)) {
    echo "Request submitted successfully.";
    header("Location: user_borrow_request.php?success=1");
    exit();
} else {
    echo "Error submitting request.";
}

mysqli_close($conn);
?>
