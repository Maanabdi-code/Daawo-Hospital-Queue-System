<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['admin_id']))
{
    header("Location: login.php");
    exit();
}

if(isset($_POST['add']))
{
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $department_id = $_POST['department_id'];

    $sql = "INSERT INTO doctors
    (
        fullname,
        email,
        phone,
        password,
        department_id,
        status,
        daily_capacity
    )
    VALUES
    (
        '$fullname',
        '$email',
        '$phone',
        '$password',
        '$department_id',
        'Active',
        200
    )";

    if(mysqli_query($conn,$sql))
    {
        echo "<script>
        alert('Doctor Added Successfully');
        window.location='dashboard.php';
        </script>";
    }
    else
    {
        die(mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Doctor</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">

<h2>Add New Doctor</h2>

<form method="POST">

<input type="text"
name="fullname"
placeholder="Doctor Name"
required>

<br><br>

<input type="email"
name="email"
placeholder="Email"
required>

<br><br>

<input type="text"
name="phone"
placeholder="Phone"
required>

<br><br>

<input type="password"
name="password"
placeholder="Password"
required>

<br><br>

<select name="department_id" required>

<option value="">
Choose Department
</option>

<option value="1">
General Medicine
</option>

<option value="2">
Dental Clinic
</option>

<option value="3">
Children's Clinic
</option>

<option value="4">
Emergency
</option>

</select>

<br><br>

<button type="submit"
name="add">
Add Doctor
</button>

</form>

</div>

</body>
</html>