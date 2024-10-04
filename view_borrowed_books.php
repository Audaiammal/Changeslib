<?php
// view_borrowed_books.php (Admin-side page)
include '../dbcon.php';

// Fetch pending borrow requests
$sql = "SELECT br.id, br.book_id, br.member_id, m.firstname, m.lastname, m.roll_number, b.Booktitle, br.request_date 
        FROM borrow_requests br 
        JOIN member m ON br.member_id = m.member_id 
        JOIN book b ON br.book_id = b.id 
        WHERE br.status = 'pending'";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrow Requests</title>
    <link rel="stylesheet" href="path-to-bootstrap.css">
</head>
<body>
    <h1>Borrow Requests</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Book Title</th>
                <th>Member Name</th>
                <th>Roll Number</th>
                <th>Request Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['Booktitle']; ?></td>
                    <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                    <td><?php echo $row['roll_number']; ?></td>
                    <td><?php echo $row['request_date']; ?></td>
                    <td>
                        <!-- Issue Button -->
                        <form method="POST" action="issue_book.php" style="display:inline;">
                            <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                            <input type="hidden" name="member_id" value="<?php echo $row['member_id']; ?>">
                            <button type="submit" class="btn btn-success">Issue</button>
                        </form>

                        <!-- Reject Button -->
                        <form method="POST" action="reject_request.php" style="display:inline;">
                            <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
