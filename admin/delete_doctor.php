<?php
include("../includes/db.php");

$id = $_GET['id'];

$sql = "DELETE FROM doctors WHERE id = $id";

mysqli_query($conn, $sql);

header("Location: dashboard.php");
exit();
?>

