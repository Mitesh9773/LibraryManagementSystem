<?php
include '../includes/db.php';

// Get today's date
$today = date("Y-m-d");

// Find overdue books that are not yet returned
$query = "SELECT issue_id, user_id, due_date FROM issued_books WHERE return_status = 'Issued' AND due_date < ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $issue_id = $row['issue_id'];
    $user_id = $row['user_id'];
    $due_date = $row['due_date'];

    // Calculate overdue days
    $overdue_days = ceil((strtotime($today) - strtotime($due_date)) / (60 * 60 * 24));
    $fine_amount = $overdue_days * 10; // ₹10 per day fine

    // Check if fine already exists
    $check_query = "SELECT * FROM fines WHERE issue_id = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("i", $issue_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Update existing fine
        $update_query = "UPDATE fines SET amount = ?, status = 'Unpaid' WHERE issue_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ii", $fine_amount, $issue_id);
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        // Insert new fine
        $insert_query = "INSERT INTO fines (issue_id, user_id, amount, status, payment_date) VALUES (?, ?, ?, 'Unpaid', NULL)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("iii", $issue_id, $user_id, $fine_amount);
        $insert_stmt->execute();
        $insert_stmt->close();
    }
}

// Close connections
$stmt->close();
$conn->close();

echo "Fines updated successfully!";
?>
