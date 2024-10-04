<?php
include 'dbcon.php'; // Database connection

// Fetch returned books
$query = "SELECT b.Accno, b.Booktitle, t.borrow_date, t.due_date, t.return_date 
          FROM transactions t 
          JOIN book b ON t.book_id = b.id 
          WHERE t.member_id = ? AND t.status = 'returned'"; // Get member_id dynamically

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $member_id); // Set the member_id
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Returned Books</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background-color: navy; color: white;">
    <div class="container mt-5">
        <h2>Returned Books</h2>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Acc No</th>
                    <th>Title</th>
                    <th>Borrow Date</th>
                    <th>Due Date</th>
                    <th>Return Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['Accno']; ?></td>
                        <td><?php echo $row['Booktitle']; ?></td>
                        <td><?php echo $row['borrow_date']; ?></td>
                        <td><?php echo $row['due_date']; ?></td>
                        <td><?php echo $row['return_date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
