<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Reports</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="container">

    <h2>Reports Dashboard</h2>

    <br>

    <a href="doctor_report.php">
        <button>Doctor Report</button>
    </a>

    <br><br>

    <a href="department_report.php">
        <button>Department Report</button>
    </a>

    <br><br>

    <a href="patient_report.php">
        <button>Patient Report</button>
    </a>

    <br><br>

    <a href="dashboard.php">
        <button>Back To Dashboard</button>
    </a>

</div>

</body>

</html>