<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['issue_id'])) {
    $issue_id = $_POST['issue_id'];

    // Update book return status
    $query = "UPDATE issued_books SET return_status = 'Returned' WHERE issue_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $issue_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
