<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$ticket_id = $_GET['id'];
$doctor_id = $_SESSION['doctor_id'];

// Soo qaad ticket-ka
$get_ticket = mysqli_query($conn,
"SELECT *
FROM tickets
WHERE id='$ticket_id'");

$ticket = mysqli_fetch_assoc($get_ticket);

$department_id = $ticket['department_id'];
$patient_id = $ticket['patient_id'];


// ===================================
// Patient-kii hore -> Completed
// ===================================

mysqli_query($conn,
"UPDATE tickets
SET status='Completed'
WHERE department_id='$department_id'
AND status='Serving'");


// ===================================
// Patient-kan -> Serving
// ===================================

mysqli_query($conn,
"UPDATE tickets
SET status='Serving',
doctor_id='$doctor_id'
WHERE id='$ticket_id'");


// ===================================
// Notification: Your Turn
// ===================================

$message = "It is now your turn. Please proceed to the doctor room.";

$check = mysqli_query($conn,
"SELECT *
FROM notifications
WHERE patient_id='$patient_id'
AND ticket_id='$ticket_id'");

if(mysqli_num_rows($check)==0)
{
    mysqli_query($conn,
    "INSERT INTO notifications
    (patient_id,ticket_id,message)

    VALUES
    ('$patient_id',
     '$ticket_id',
     '$message')");
}


// ===================================
// Update Queue Positions
// ===================================

$result = mysqli_query($conn,
"SELECT id
FROM tickets
WHERE department_id='$department_id'
AND status='Waiting'
ORDER BY queue_position ASC");

$position = 1;

while($row=mysqli_fetch_assoc($result))
{
    $id = $row['id'];

    mysqli_query($conn,
    "UPDATE tickets
    SET queue_position='$position'
    WHERE id='$id'");

    $position++;
}


// ===================================
// Notify patient with only 3 remaining
// ===================================

$notify = mysqli_query($conn,
"SELECT *
FROM tickets
WHERE department_id='$department_id'
AND status='Waiting'
AND queue_position='4'");

while($n=mysqli_fetch_assoc($notify))
{

    $patient_id_notify = $n['patient_id'];
    $ticket_id_notify = $n['id'];

    $message =
    "Only 3 patients remain ahead of you. Please prepare to visit the doctor.";

    $check2=mysqli_query($conn,
    "SELECT *
    FROM notifications
    WHERE patient_id='$patient_id_notify'
    AND ticket_id='$ticket_id_notify'
    AND message='$message'");

    if(mysqli_num_rows($check2)==0)
    {
        mysqli_query($conn,
        "INSERT INTO notifications
        (patient_id,ticket_id,message)

        VALUES
        ('$patient_id_notify',
         '$ticket_id_notify',
         '$message')");
    }

}

header("Location: dashboard.php");
exit();

?>