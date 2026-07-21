<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$date = "";

if (isset($_GET['date'])) {
    $date = $_GET['date'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Daily Hospital Report</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="container">

    <h2>Daily Hospital Report</h2>

    <form method="GET">

        <label>Select Date</label>

        <input
        type="date"
        name="date"
        value="<?php echo $date; ?>"
        required>

        <button type="submit">
            Search
        </button>

    </form>

    <br><br>

<?php

if($date != "")
{

    echo "<h3>Report Date : ".$date."</h3>";

    // Total Patients
    $q1 = mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM tickets
    WHERE booking_date='$date'");

    $total_patients = mysqli_fetch_assoc($q1)['total'];

    // Waiting
    $q2 = mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM tickets
    WHERE booking_date='$date'
    AND status='Waiting'");

    $waiting = mysqli_fetch_assoc($q2)['total'];

    // Serving
    $q3 = mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM tickets
    WHERE booking_date='$date'
    AND status='Serving'");

    $serving = mysqli_fetch_assoc($q3)['total'];

    // Completed
    $q4 = mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM tickets
    WHERE booking_date='$date'
    AND status='Completed'");

    $completed = mysqli_fetch_assoc($q4)['total'];

    // Active Doctors
    $q5 = mysqli_query($conn,"
    SELECT COUNT(DISTINCT doctor_id) AS total
    FROM tickets
    WHERE booking_date='$date'
    AND doctor_id IS NOT NULL");

    $doctors = mysqli_fetch_assoc($q5)['total'];

    // Departments
    $q6 = mysqli_query($conn,"
    SELECT COUNT(DISTINCT department_id) AS total
    FROM tickets
    WHERE booking_date='$date'");

    $departments = mysqli_fetch_assoc($q6)['total'];

?>

<h3>Hospital Summary</h3>

<table border="1" cellpadding="10" cellspacing="0" width="100%">

<tr>
    <th>Total Patients</th>
    <th>Waiting</th>
    <th>Serving</th>
    <th>Completed</th>
    <th>Doctors</th>
    <th>Departments</th>
</tr>

<tr>

    <td><?php echo $total_patients; ?></td>
    <td><?php echo $waiting; ?></td>
    <td><?php echo $serving; ?></td>
    <td><?php echo $completed; ?></td>
    <td><?php echo $doctors; ?></td>
    <td><?php echo $departments; ?></td>

</tr>

</table>

<br><br>
<h3>Department Summary</h3>

<table border="1" cellpadding="10" cellspacing="0" width="100%">

<tr>
    <th>Department</th>
    <th>Total Patients</th>
    <th>Waiting</th>
    <th>Serving</th>
    <th>Completed</th>
</tr>

<?php

$sql = "
SELECT
departments.department_name,

COUNT(tickets.id) AS total,

SUM(CASE WHEN tickets.status='Waiting' THEN 1 ELSE 0 END) AS waiting,

SUM(CASE WHEN tickets.status='Serving' THEN 1 ELSE 0 END) AS serving,

SUM(CASE WHEN tickets.status='Completed' THEN 1 ELSE 0 END) AS completed

FROM departments

LEFT JOIN tickets
ON departments.id=tickets.department_id
AND tickets.booking_date='$date'

GROUP BY departments.id
";

$result=mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $row['department_name']; ?></td>

<td><?php echo $row['total']; ?></td>

<td><?php echo $row['waiting']; ?></td>

<td><?php echo $row['serving']; ?></td>

<td><?php echo $row['completed']; ?></td>

</tr>

<?php
}
?>

</table>

<br><br>
<h3>Doctor Summary</h3>



<table border="1" cellpadding="10" cellspacing="0" width="100%">

<tr>
    <th>Doctor</th>
    <th>Department</th>
    <th>Total Patients</th>
    <th>Waiting</th>
    <th>Serving</th>
    <th>Completed</th>
</tr>

<?php

$sql = "
SELECT
doctors.fullname,
departments.department_name,

COUNT(tickets.id) AS total,

SUM(CASE WHEN tickets.status='Waiting' THEN 1 ELSE 0 END) AS waiting,

SUM(CASE WHEN tickets.status='Serving' THEN 1 ELSE 0 END) AS serving,

SUM(CASE WHEN tickets.status='Completed' THEN 1 ELSE 0 END) AS completed

FROM doctors

LEFT JOIN departments
ON doctors.department_id = departments.id

LEFT JOIN tickets
ON doctors.id = tickets.doctor_id
AND tickets.booking_date='$date'

GROUP BY doctors.id

ORDER BY doctors.fullname
";

$result = mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result))
{
?>

<tr>

<td><?php echo $row['fullname']; ?></td>

<td><?php echo $row['department_name']; ?></td>

<td><?php echo $row['total']; ?></td>

<td><?php echo $row['waiting']; ?></td>

<td><?php echo $row['serving']; ?></td>

<td><?php echo $row['completed']; ?></td>

</tr>

<?php
}
?>

</table>

<br><br>
<h3>Patient Details</h3>

<table border="1" cellpadding="10" cellspacing="0" width="100%">

<tr>
    <th>Patient</th>
    <th>Ticket</th>
    <th>Department</th>
    <th>Doctor</th>
    <th>Status</th>
    <th>Queue Position</th>
</tr>

<?php

$sql = "
SELECT
patients.fullname,
tickets.ticket_number,
departments.department_name,
doctors.fullname AS doctor_name,
tickets.status,
tickets.queue_position

FROM tickets

INNER JOIN patients
ON tickets.patient_id = patients.id

INNER JOIN doctors
ON tickets.doctor_id = doctors.id

INNER JOIN departments
ON tickets.department_id = departments.id

WHERE tickets.booking_date='$date'

ORDER BY
departments.department_name,
tickets.queue_position ASC
";

$result = mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result))
{
?>

<tr>

<td><?php echo $row['fullname']; ?></td>

<td><?php echo $row['ticket_number']; ?></td>

<td><?php echo $row['department_name']; ?></td>

<td><?php echo $row['doctor_name']; ?></td>

<td><?php echo $row['status']; ?></td>

<td><?php echo $row['queue_position']; ?></td>

</tr>

<?php
}
?>

</table>

<br><br>
<br><br>

<a href="export_pdf.php?date=<?php echo $date; ?>">
    <button>Export PDF</button>
</a>

&nbsp;
<a href="daily_report.php">
    <button>Back</button>
</a>
<?php
}
?>



</div>

</body>
</html>