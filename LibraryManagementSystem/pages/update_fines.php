<?php
include '../includes/db.php';

// Fine settings
$per_day_fine = 10; // ₹10 per day after the due date

// Update fines for overdue books
$query = "UPDATE fines f
          JOIN issued_books ib ON f.user_id = ib.user_id
          SET f.amount = DATEDIFF(CURDATE(), ib.due_date) * ?
          WHERE CURDATE() > ib.due_date AND f.status = 'unpaid'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $per_day_fine);
$stmt->execute();

echo "Fines updated successfully!";
?>
