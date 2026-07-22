<!-- <?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_GET['date']))
{
    $date = $_GET['date'];
}
else
{
    $date = date("Y-m-d");
}

$sql = "
SELECT
patients.fullname AS patient_name,
tickets.ticket_number,
departments.department_name,
doctors.fullname AS doctor_name,
tickets.status,
tickets.booking_date

FROM tickets

INNER JOIN patients
ON tickets.patient_id = patients.id

INNER JOIN departments
ON tickets.department_id = departments.id

LEFT JOIN doctors
ON tickets.doctor_id = doctors.id

WHERE tickets.booking_date='$date'

ORDER BY tickets.ticket_number ASC
";

$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>

<head>

<title>Patient Daily Report</title>

<form method="GET">

<label>Select Date:</label>

<input type="date"
name="date"
value="<?php echo isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'); ?>">

<button type="submit">Search</button>

</form>

<br>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Patient Daily Report</h2>

<p><strong>Date:</strong> <?php echo $date; ?></p>

<table border="1" cellpadding="10">

<tr>

<th>Patient</th>
<th>Ticket</th>
<th>Department</th>
<th>Doctor</th>
<th>Status</th>
<th>Date</th>

</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['patient_name']; ?></td>

<td><?php echo $row['ticket_number']; ?></td>

<td><?php echo $row['department_name']; ?></td>

<td><?php echo $row['doctor_name']; ?></td>

<td><?php echo $row['status']; ?></td>

<td><?php echo $row['booking_date']; ?></td>

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