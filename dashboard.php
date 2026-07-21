<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

$doctor_name = $_SESSION['doctor_name'];
$department_id = $_SESSION['department_id'];
$doctor_id = $_SESSION['doctor_id'];

// Soo qaad department-ka doctor-ka
$getDoctor = mysqli_query($conn,
"SELECT department_id
FROM doctors
WHERE id='$doctor_id'");

$d = mysqli_fetch_assoc($getDoctor);
$department_id = $d['department_id'];

$waiting_query = mysqli_query($conn,
"SELECT COUNT(*) AS total
FROM tickets
WHERE department_id='$department_id'
AND status='Waiting'");

$waiting = mysqli_fetch_assoc($waiting_query);
$waiting_total = $waiting['total'];

$serving_query = mysqli_query($conn,
"SELECT COUNT(*) AS total
FROM tickets
WHERE department_id='$department_id'
AND status='Serving'");

$serving = mysqli_fetch_assoc($serving_query);
$serving_total = $serving['total'];

$completed_query = mysqli_query($conn,
"SELECT COUNT(*) AS total
FROM tickets
WHERE department_id='$department_id'
AND status='Completed'");

$completed = mysqli_fetch_assoc($completed_query);
$completed_total = $completed['total'];

$sql = "
SELECT tickets.*, patients.fullname
FROM tickets
INNER JOIN patients
ON tickets.patient_id = patients.id
WHERE tickets.department_id='$department_id'
AND (tickets.status='Waiting' OR tickets.status='Serving')
ORDER BY
CASE
WHEN tickets.status='Serving' THEN 0
ELSE 1
END,
tickets.queue_position ASC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">

    <h2>Welcome Dr. <?php echo $doctor_name; ?></h2>

    <div class="stats">

        <div class="card">
            <h3>Waiting</h3>
            <h2><?php echo $waiting_total; ?></h2>
        </div>

        <div class="card">
            <h3>Serving</h3>
            <h2><?php echo $serving_total; ?></h2>
        </div>

        <div class="card">
            <h3>Completed</h3>
            <h2><?php echo $completed_total; ?></h2>
        </div>

    </div>

    <h3>Waiting Patients</h3>

    <table border="1" cellpadding="10">
        <tr>
            <th>Patient Name</th>
            <th>Ticket Number</th>
            <th>Queue Position</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <tr>
            <td><?php echo $row['fullname']; ?></td>
            <td><?php echo $row['ticket_number']; ?></td>
            <td><?php echo $row['queue_position']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>

                <?php if($row['status'] == 'Waiting') { ?>

                    <a href="call_patient.php?id=<?php echo $row['id']; ?>">
                        <button>Call</button>
                    </a>

                <?php } else { ?>

                    -

                <?php } ?>

            </td>
        </tr>

        <?php } ?>

    </table>

    <div style="text-align:right; margin-top:20px;">

        <a href="logout.php">
            <button style="
                background:#dc3545;
                color:white;
                border:none;
                padding:10px 20px;
                border-radius:8px;
                cursor:pointer;
                font-weight:bold;
            ">
                Logout
            </button>
        </a>

    </div>

</div>

</body>
</html>