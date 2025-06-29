<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $fine_id = $_POST['fine_id'];

    // Update fine status to 'paid' and amount to 0
    $query = "UPDATE fines SET status = 'paid', amount = 0, payment_date = NOW() WHERE fine_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $fine_id);
    $stmt->execute();

    $_SESSION['success_message'] = "Payment successful! Fine cleared.";
    header("Location: issued_books.php");
    exit();
}
?>
