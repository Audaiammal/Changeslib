<?php
// issue_book.php (Issuing a book to a member)
include '../dbcon.php';

$request_id = $_POST['request_id'];
$book_id = $_POST['book_id'];
$member_id = $_POST['member_id'];

// Set the book as issued and set a due date (e.g., 14 days from now)
$due_date = date('Y-m-d', strtotime('+14 days'));

$sql = "UPDATE borrow_requests SET status = 'borrowed', borrow_date = NOW(), due_date = ? WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("si", $due_date, $request_id);
$stmt->execute();

echo "Book has been successfully issued.";
?>
