<?php
// Include database connection file
include 'dbcon.php';

// Initialize message variable
$message = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the member_id and book_id from the form submission
    $member_id = $_POST['member_id'];
    $book_id = $_POST['book_id'];

    // Check if the member_id exists
    $memberCheck = $conn->query("SELECT * FROM member WHERE member_id = '$member_id'");
    if ($memberCheck->num_rows === 0) {
        $message = "The member does not exist.";
    } else {
        // Check the number of copies available for the book
        $bookCheck = $conn->query("SELECT Copies FROM book WHERE id = '$book_id'");
        $bookRow = $bookCheck->fetch_assoc();

        if ($bookRow && $bookRow['Copies'] > 0) {
            // Decrease the number of copies in the book table
            $newCopies = $bookRow['Copies'] - 1;
            $updateBook = $conn->query("UPDATE book SET Copies = $newCopies WHERE id = '$book_id'");

            if ($updateBook) {
                // Insert a new borrow request
                $requestDate = date('Y-m-d'); // Current date
                $insertRequest = $conn->query("INSERT INTO borrow_requests (member_id, book_id, request_date) VALUES ('$member_id', '$book_id', '$requestDate')");

                if ($insertRequest) {
                    $message = "Your borrow request has been made successfully.";
                } else {
                    $message = "Failed to make the borrow request.";
                }
            } else {
                $message = "Failed to update book copies.";
            }
        } else {
            $message = "The book is not available for borrowing.";
        }
    }
}

// Redirect back to the browse books page with a message
header("Location: browse_books.php?message=" . urlencode($message));
exit();
