<?php
session_start();
include("../includes/db.php");

// Haddii aanu user-ku login samayn
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];

// Soo qaado ticket-kii ugu dambeeyey ee patient-kan
$sql = "SELECT *
        FROM tickets
        WHERE patient_id='$patient_id'
        ORDER BY id DESC
        LIMIT 1";

$result = mysqli_query($conn, $sql);
$ticket = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Queue Status</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">

    <h2>My Queue Status</h2>

    <?php if ($ticket) { ?>

        <p><strong>Ticket Number:</strong>
            <?php echo $ticket['ticket_number']; ?>
        </p>

        <p><strong>Queue Position:</strong>
            <?php echo $ticket['queue_position']; ?>
        </p>

        <p><strong>Status:</strong>
            <?php echo $ticket['status']; ?>
        </p>

        <p><strong>Booking Date:</strong>
            <?php echo $ticket['booking_date']; ?>
        </p>

    <?php } else { ?>

        <p>You have not booked any ticket yet.</p>

    <?php } ?>

    <br>

    <a href="dashboard.php">
        <button>Back to Dashboard</button>
    </a>

</div>

</body>
</html>