<?php
include("../includes/db.php");

$id = $_GET['id'];

$sql = "SELECT * FROM doctors WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department_id = $_POST['department_id'];

    $sql = "UPDATE doctors
            SET fullname='$fullname',
                email='$email',
                phone='$phone',
                department_id='$department_id'
            WHERE id=$id";

    mysqli_query($conn, $sql);

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Doctor</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">

<h2>Edit Doctor</h2>

<form method="POST">

    <input type="text"
           name="fullname"
           value="<?php echo $row['fullname']; ?>"
           required>

    <br><br>

    <input type="email"
           name="email"
           value="<?php echo $row['email']; ?>"
           required>

    <br><br>

    <input type="text"
           name="phone"
           value="<?php echo $row['phone']; ?>"
           required>

    <br><br>

    <input type="number"
           name="department_id"
           value="<?php echo $row['department_id']; ?>"
           required>

    <br><br>

    <button type="submit" name="update">
        Update Doctor
    </button>

</form>

</div>

</body>
</html>