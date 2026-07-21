<?php
session_start();
include("../includes/db.php");

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT *
            FROM admins
            WHERE email='$email'
            AND password='$password'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);

        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['fullname'] = $row['fullname'];

        header("Location: dashboard.php");
        exit();
    }
    else
    {
        echo "<script>
        alert('Invalid Email or Password');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="form-page">

<div class="form-container">

    <h2>Admin Login</h2>

    <form method="POST">

        <input type="email"
               name="email"
               placeholder="Enter Email"
               required>

        <br><br>

        <input type="password"
               name="password"
               placeholder="Enter Password"
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