<?php
session_start();
include("../includes/db.php");

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM doctors
            WHERE email='$email'
            AND password='$password'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);

        $_SESSION['doctor_id'] = $row['id'];
        $_SESSION['doctor_name'] = $row['fullname'];
        $_SESSION['department_id'] = $row['department_id'];

        header("Location: dashboard.php");
        exit();
    }
    else
    {
        echo "<script>alert('Invalid Login');</script>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
<title>Doctor Login</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="form-page">

<div class="form-container">

<h2>Doctor Login</h2>

<form method="POST">

<input type="email"
name="email"
placeholder="Email"
required>

<br><br>

<input type="password"
name="password"
placeholder="Password"
required>

<br><br>

<button type="submit"
name="login">
Login
</button>

</form>

</div>

</body>
</html>