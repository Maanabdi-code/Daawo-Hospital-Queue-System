<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['patient_id'])){
    header("Location: login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];
$department_id = $_POST['department_id'];
$date = date("Y-m-d");
// Soo qaad doctor-ka department-kan
$get_doctor = mysqli_query($conn,
"SELECT *
FROM doctors
WHERE department_id='$department_id'
AND status='Active'
LIMIT 1");
if(mysqli_num_rows($get_doctor) == 0)
{
    echo "<script>
    alert('No active doctor available in this department.');
    window.location='dashboard.php';
    </script>";
    exit();
}

if(mysqli_num_rows($get_doctor) == 0)
{
    echo "<script>
    alert('No active doctor available in this department.');
    window.location='dashboard.php';
    </script>";
    exit();
}

$doctor = mysqli_fetch_assoc($get_doctor);

$doctor_id = $doctor['id'];
$capacity = $doctor['daily_capacity'];

// Tirso bukaanada maanta
$count = mysqli_query($conn,
"SELECT COUNT(*) AS total
FROM tickets
WHERE doctor_id='$doctor_id'
AND booking_date='$date'");

$c = mysqli_fetch_assoc($count);

$total_patients = $c['total'];

// Hubi capacity-ga
if($total_patients >= $capacity)
{
    echo "<script>
    alert('Doctor capacity for today is full.');
    window.location='dashboard.php';
    </script>";
    exit();
}

$check = "SELECT * FROM tickets
          WHERE patient_id='$patient_id'
          AND booking_date='$date'";

$result = mysqli_query($conn,$check);

if(mysqli_num_rows($result) > 0){

    echo "<script>
    alert('You already have a ticket today');
    window.location='dashboard.php';
    </script>";

    exit();
}

if($department_id == 1){
    $prefix = "G";
}
elseif($department_id == 2){
    $prefix = "D";
}
elseif($department_id == 3){
    $prefix = "C";
}
else{
    $prefix = "E";
}

# soo saar ticketkii udanbeeyey
$sql = "SELECT * FROM tickets
        WHERE department_id='$department_id'
        AND booking_date='$date'
        ORDER BY id DESC
        LIMIT 1";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) > 0){

    $row = mysqli_fetch_assoc($result);

    $last_ticket = $row['ticket_number'];

    $number = substr($last_ticket,1);

    $number++;

}else{
    $number = 1;
}
# sameee id_ga patientska
$ticket_number =
$prefix . str_pad($number,3,"0",STR_PAD_LEFT);

# queue position
$queue_position = $number;

#emergency
$is_emergency = 0;

if($department_id == 4){
    $is_emergency = 1;
}

$insert = "INSERT INTO tickets
(patient_id,
doctor_id,
department_id,
ticket_number,
booking_date,
queue_position,
status,
is_emergency)

VALUES
('$patient_id',
'$doctor_id',
'$department_id',
'$ticket_number',
'$date',
'$queue_position',
'Waiting',
'$is_emergency')";

if(mysqli_query($conn,$insert)){

    echo "<script>
    alert('Your Ticket Number is: $ticket_number');
    window.location='dashboard.php';
    </script>";
}

?>




