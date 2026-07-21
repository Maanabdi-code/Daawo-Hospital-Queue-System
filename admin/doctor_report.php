<!-- <?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

$date = date("Y-m-d");

$sql = "
SELECT
d.fullname,
dep.department_name,

COUNT(t.id) AS total_patients,

SUM(CASE WHEN t.status='Waiting' THEN 1 ELSE 0 END) AS waiting,

SUM(CASE WHEN t.status='Serving' THEN 1 ELSE 0 END) AS serving,

SUM(CASE WHEN t.status='Completed' THEN 1 ELSE 0 END) AS completed

FROM doctors d

LEFT JOIN departments dep
ON d.department_id = dep.id

LEFT JOIN tickets t
ON d.id = t.doctor_id
AND t.booking_date='$date'

GROUP BY d.id

ORDER BY d.fullname ASC
";

$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>

<head>

<title>Doctor Daily Report</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Doctor Daily Report</h2>

<p><strong>Date:</strong> <?php echo $date; ?></p>

<table border="1" cellpadding="10">

<tr>

<th>Doctor</th>

<th>Department</th>

<th>Total Patients</th>

<th>Waiting</th>

<th>Serving</th>

<th>Completed</th>

</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['fullname']; ?></td>

<td><?php echo $row['department_name']; ?></td>

<td><?php echo $row['total_patients']; ?></td>

<td><?php echo $row['waiting']; ?></td>

<td><?php echo $row['serving']; ?></td>

<td><?php echo $row['completed']; ?></td>

</tr>

<?php } ?>

</table>

<br>

<a href="reports.php">
<button>Back</button>
</a>

</div>

</body>

</html> -->