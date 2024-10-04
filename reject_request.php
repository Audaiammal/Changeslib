<?php
// reject_request.php (Rejecting a borrow request)
include '../dbcon.php';

$request_id = $_POST['request_id'];

// Reject the request
$sql = "UPDATE borrow_requests SET status = 'rejected' WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $request_id);
$stmt->execute();

echo "Borrow request has been rejected.";
?>
