<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['patient_id']))
{
    header("Location: login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];

$sql = "SELECT *
        FROM notifications
        WHERE patient_id='$patient_id'
        ORDER BY id DESC";

$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Notifications</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">

<h2>My Notifications</h2>

<?php
if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_assoc($result))
    {
        echo "<p>".$row['message']."</p>";
        echo "<hr>";
    }
}
else
{
    echo "<p>No notifications yet.</p>";
}
?>

<a href='dashboard.php'>
    <button>Back to Dashboard</button>
</a>

</div>

</body>
</html>