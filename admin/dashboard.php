<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM doctors";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>



    <div class="container">

        <h2>Admin Dashboard</h2>

        <a href="add_doctor.php">
            <button>Add New Doctor</button>
        </a>



        <br><br>

        <table border="1" cellpadding="10">

            <tr>
                <th>Doctor Name</th>
                <th>Department ID</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            ?>

                <tr>

                    <td><?php echo $row['fullname']; ?></td>

                    <td><?php echo $row['department_id']; ?></td>

                    <td><?php echo $row['status']; ?></td>

                    <td>

                        <a href="edit_doctor.php?id=<?php echo $row['id']; ?>">
                            <button>Edit</button>
                        </a>

                        <a href="delete_doctor.php?id=<?php echo $row['id']; ?>"
                            onclick="return confirm('Are you sure you want to delete this doctor?');">
                            <button>Delete</button>
                        </a>

                        <?php if ($row['status'] == "Active") { ?>

                            <a href="change_doctor_status.php?id=<?php echo $row['id']; ?>&status=Inactive">
                                <button>Deactivate</button>
                            </a>

                        <?php } else { ?>

                            <a href="change_doctor_status.php?id=<?php echo $row['id']; ?>&status=Active">
                                <button>Activate</button>
                            </a>

                        <?php } ?>

                    </td>

                </tr>

            <?php
            }
            ?>

        </table>
        <br><br>

        <a href="daily_report.php">
            <button>Daily Report</button>
        </a>
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