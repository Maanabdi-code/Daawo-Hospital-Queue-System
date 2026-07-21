<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['patient_id'])){
    header("Location: login.php");
    exit();
}

$fullname = $_SESSION['fullname'];
$patient_id = $_SESSION['patient_id'];

$notification_sql = "
SELECT *
FROM notifications
WHERE patient_id='$patient_id'
ORDER BY id DESC
LIMIT 1
";

$notification_result = mysqli_query($conn, $notification_sql);

if(!isset($_SESSION['patient_id'])){
    header("Location: login.php");
    exit();
}

$fullname = $_SESSION['fullname'];
$patient_id = $_SESSION['patient_id'];

$sql_notification =
"SELECT *
 FROM notifications
 WHERE patient_id='$patient_id'
 ORDER BY id DESC
 LIMIT 1";

$result_notification =
mysqli_query($conn,$sql_notification);

$notification =
mysqli_fetch_assoc($result_notification);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php
if($notification)
{
?>
<script>
alert("<?php echo $notification['message']; ?>");
</script>
<?php
}
?>

<div class="container">

    <img src="../assets/images/logo.png" class="logo">

    <h2>Welcome, <?php echo $fullname; ?></h2>
    <?php
if(mysqli_num_rows($notification_result) > 0)
{
    $notification = mysqli_fetch_assoc($notification_result);
?>
    <div
    style="
    background:#fff3cd;
    color:#856404;
    padding:15px;
    border:1px solid #ffeeba;
    border-radius:8px;
    margin-bottom:20px;
    ">
        <strong>Notification:</strong><br>
        <?php echo $notification['message']; ?>
    </div>
<?php
}
?>

    <h3>Select Department</h3>

    <form action="book_ticket.php" method="POST">

        <select name="department_id" required>
            <option value="">Choose Department</option>
            <option value="1">General Medicine</option>
            <option value="2">Dental Clinic</option>
            <option value="3">Children's Clinic</option>
            <option value="4">Emergency</option>
        </select>

        <br><br>

        <button type="submit" name="book">
            Take Queue Ticket
        </button>

    </form>

    <br>

<a href="queue_status.php">View My Queue Status</a>

<br><br>

<a href="notifications.php">
    <button>Notifications</button>
</a>

<br><br>

<a href="logout.php">
    <button>Logout</button>
</a>

</div>

</body>
</html>