<?php

$conn = mysqli_connect("localhost", "root", "", "daawo_hospital_db", 3306);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

?>