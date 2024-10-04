<?php
// Include database connection file
include 'dbcon.php';

// Start the session
session_start();

// Check if the member_id is set in the session
if (!isset($_SESSION['member_id'])) {
    echo "You are not logged in.";
    exit; // Stop the script if not logged in
}

$member_id = $_SESSION['member_id'];

// Fetch borrow history for the logged-in member
$query = $conn->prepare("
    SELECT br.request_date, b.Booktitle, br.status, br.return_date
    FROM borrow_requests br
    JOIN book b ON br.book_id = b.id
    WHERE br.member_id = ?
    ORDER BY br.request_date DESC
");
$query->bind_param("i", $member_id);
$query->execute();
$result = $query->get_result();
?>

<table>
    <tr>
        <th>Request Date</th>
        <th>Book Title</th>
        <th>Status</th>
        <th>Return Date</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['request_date']; ?></td>
            <td><?php echo $row['Booktitle']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td><?php echo $row['return_date'] ? $row['return_date'] : 'N/A'; ?></td>
        </tr>
    <?php } ?>
</table>

<?php
$query->close();
?>
