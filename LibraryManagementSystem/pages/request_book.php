<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'])) {
    $user_id = $_SESSION['user_id'];
    $book_id = intval($_POST['book_id']);

    // Check if the book exists and has available copies
    $book_check_query = "SELECT available_copies FROM books WHERE book_id = '$book_id'";
    $book_check_result = mysqli_query($conn, $book_check_query);

    if ($book_check_result && mysqli_num_rows($book_check_result) > 0) {
        $book_data = mysqli_fetch_assoc($book_check_result);
        $available_copies = $book_data['available_copies'];

        if ($available_copies > 0) {
            // Check if the user already has a pending request for this book
            $existing_request_query = "SELECT * FROM borrow_requests 
                                       WHERE user_id = '$user_id' AND book_id = '$book_id' AND status = 'Pending'";
            $existing_request_result = mysqli_query($conn, $existing_request_query);

            if (mysqli_num_rows($existing_request_result) == 0) {
                // Insert borrow request into the database
                $insert_query = "INSERT INTO borrow_requests (user_id, book_id, status) VALUES ('$user_id', '$book_id', 'Pending')";
                if (mysqli_query($conn, $insert_query)) {
                    $_SESSION['success_message'] = "Book request submitted successfully!";
                } else {
                    $_SESSION['error_message'] = "Error submitting request. Please try again.";
                }
            } else {
                $_SESSION['error_message'] = "You already have a pending request for this book.";
            }
        } else {
            $_SESSION['error_message'] = "Sorry, this book is currently unavailable.";
        }
    } else {
        $_SESSION['error_message'] = "Invalid book selection.";
    }
} else {
    $_SESSION['error_message'] = "Invalid request.";
}

header("Location: borrow_request.php");
exit();
?>
