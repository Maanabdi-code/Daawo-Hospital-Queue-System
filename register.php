<?php
include("../includes/db.php");

if(isset($_POST['register'])){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $sql = "INSERT INTO patients(fullname, email, phone, password)
            VALUES('$fullname', '$email', '$phone', '$password')";

    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Registration Successful');</script>";
    }else{
        die(mysqli_error($conn));
    }
}
?>







<!DOCTYPE html>
<html>
<head>
    <title>Patient Registration</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="form-page">
    

<div class="form-container">
    <img src="../assets/images/logo.png" class="logo">

    <h2>Patient Registration</h2>

    <form method="POST">

        <input type="text"
               name="fullname"
               placeholder="Full Name"
               required>

        <br><br>

        <input type="email"
               name="email"
               placeholder="Email Address"
               required>

        <br><br>

        <input type="text"
               name="phone"
               placeholder="Phone Number"
               required>

        <br><br>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <br><br>

        <button type="submit" name="register">
            Register
        </button>

    </form>

</div>

</body>
</html>