<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if request_id is sent
if (!isset($_POST['request_id']) || empty($_POST['request_id'])) {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit();
}

$request_id = intval($_POST['request_id']);

// Check if the request exists and belongs to the user
$query = "SELECT * FROM borrow_requests WHERE request_id = ? AND user_id = ? AND status = 'Pending'";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $request_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$request = mysqli_fetch_assoc($result);

if (!$request) {
    echo json_encode(["success" => false, "message" => "Request not found or already processed."]);
    exit();
}

// Delete the request
$delete_query = "DELETE FROM borrow_requests WHERE request_id = ?";
$stmt = mysqli_prepare($conn, $delete_query);
mysqli_stmt_bind_param($stmt, "i", $request_id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to cancel request."]);
}

mysqli_close($conn);
?>
