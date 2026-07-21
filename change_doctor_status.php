<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$status = $_GET['status'];

$sql = "UPDATE doctors SET status='$status' WHERE id='$id'";

mysqli_query($conn, $sql);

header("Location: dashboard.php");
exit();
?>