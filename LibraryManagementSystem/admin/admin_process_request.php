<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_id']) && isset($_POST['status'])) {
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];

    // Update the borrow request status
    $query = "UPDATE borrow_requests SET status = ? WHERE request_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $request_id);

    if ($stmt->execute()) {
        // If request is approved, move the request to issued_books table
        if ($status === "Approved") {
            // Get book_id and user_id
            $query = "SELECT user_id, book_id FROM borrow_requests WHERE request_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $request_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                $user_id = $row['user_id'];
                $book_id = $row['book_id'];
                $issue_date = date("Y-m-d");
                $due_date = date("Y-m-d", strtotime("+15 days"));

                // Insert into issued_books table
                $query = "INSERT INTO issued_books (user_id, book_id, issue_date, due_date, return_status) VALUES (?, ?, ?, ?, 'Issued')";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iiss", $user_id, $book_id, $issue_date, $due_date);
                $stmt->execute();
            }
        }

        echo json_encode(["success" => true, "message" => "Request " . strtolower($status) . " successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating request."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
