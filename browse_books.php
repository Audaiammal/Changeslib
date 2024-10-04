<?php
session_start(); // Start the session to access session variables

// Include database connection file
include 'dbcon.php';

// Initialize message variable
$message = '';

// Check if there is a message in the URL
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}

// Check if the member ID is available in the session
if (isset($_SESSION['member_id'])) {
    $member_id = $_SESSION['member_id']; // Get the logged-in member's ID
} else {
    // If member_id is not set, redirect to login page or display an error
    die("Member not logged in."); // Handle this as per your application's flow
}

// Fetch available books
$result = $conn->query("SELECT id, Booktitle, Author, Copies FROM book WHERE Copies > 0");

// Check if the query was successful
if (!$result) {
    die("Database query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Books</title>
    <link rel="stylesheet" href="your_styles.css"> <!-- Link your CSS file here -->
</head>
<body>
    <h1>Available Books</h1>

    <?php if ($message): ?>
        <div id="message">
            <p><?php echo htmlspecialchars($message); ?></p>
        </div>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Copies</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Booktitle']); ?></td>
                    <td><?php echo htmlspecialchars($row['Author']); ?></td>
                    <td><?php echo $row['Copies']; ?></td>
                    <td>
                        <form method="POST" action="process_borrow_request.php">
                            <input type="hidden" name="member_id" value="<?php echo htmlspecialchars($member_id); ?>"> <!-- Set this value dynamically -->
                            <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <button type="submit" name="borrow">Borrow</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="member_dashboard.php">Return to Dashboard</a>
</body>
</html>
