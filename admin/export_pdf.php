<?php
session_start();

include("../includes/db.php");
require("../fpdf186/fpdf186/fpdf.php");

if(!isset($_SESSION['admin_id']))
{
    header("Location: login.php");
    exit();
}

$date = "";

if(isset($_GET['date']))
{
    $date = $_GET['date'];
}

if($date=="")
{
    die("No date selected.");
}

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',18);
$pdf->Cell(190,10,'DAAWO HOSPITAL',0,1,'C');

$pdf->SetFont('Arial','',14);
$pdf->Cell(190,8,'Daily Hospital Report',0,1,'C');

$pdf->Ln(5);

$pdf->SetFont('Arial','',12);
$pdf->Cell(40,8,'Report Date :');
$pdf->Cell(50,8,$date);
$pdf->Ln(12);   

$q1 = mysqli_query($conn,"
SELECT COUNT(*) total
FROM tickets
WHERE booking_date='$date'");

$total_patients = mysqli_fetch_assoc($q1)['total'];

$q2 = mysqli_query($conn,"
SELECT COUNT(*) total
FROM tickets
WHERE booking_date='$date'
AND status='Waiting'");

$waiting = mysqli_fetch_assoc($q2)['total'];

$q3 = mysqli_query($conn,"
SELECT COUNT(*) total
FROM tickets
WHERE booking_date='$date'
AND status='Serving'");

$serving = mysqli_fetch_assoc($q3)['total'];

$q4 = mysqli_query($conn,"
SELECT COUNT(*) total
FROM tickets
WHERE booking_date='$date'
AND status='Completed'");

$completed = mysqli_fetch_assoc($q4)['total'];

$q5 = mysqli_query($conn,"
SELECT COUNT(DISTINCT doctor_id) total
FROM tickets
WHERE booking_date='$date'");

$doctors = mysqli_fetch_assoc($q5)['total'];

$q6 = mysqli_query($conn,"
SELECT COUNT(DISTINCT department_id) total
FROM tickets
WHERE booking_date='$date'");

$departments = mysqli_fetch_assoc($q6)['total'];

$pdf->SetFont('Arial','B',14);
$pdf->Cell(190,10,'Hospital Summary',0,1);

$pdf->SetFont('Arial','B',10);

$pdf->Cell(30,10,'Patients',1);
$pdf->Cell(30,10,'Waiting',1);
$pdf->Cell(30,10,'Serving',1);
$pdf->Cell(30,10,'Completed',1);
$pdf->Cell(30,10,'Doctors',1);
$pdf->Cell(40,10,'Departments',1);

$pdf->Ln();

$pdf->SetFont('Arial','',10);

$pdf->Cell(30,10,$total_patients,1);
$pdf->Cell(30,10,$waiting,1);
$pdf->Cell(30,10,$serving,1);
$pdf->Cell(30,10,$completed,1);
$pdf->Cell(30,10,$doctors,1);
$pdf->Cell(40,10,$departments,1);

$pdf->Ln(15); 

$pdf->SetFont('Arial','B',14);
$pdf->Cell(190,10,'Department Summary',0,1);

$pdf->SetFont('Arial','B',10);

$pdf->Cell(55,10,'Department',1);
$pdf->Cell(27,10,'Patients',1);
$pdf->Cell(27,10,'Waiting',1);
$pdf->Cell(27,10,'Serving',1);
$pdf->Cell(27,10,'Completed',1);

$pdf->Ln();

$sql = "
SELECT
departments.department_name,

COUNT(tickets.id) total,

SUM(CASE WHEN tickets.status='Waiting' THEN 1 ELSE 0 END) waiting,

SUM(CASE WHEN tickets.status='Serving' THEN 1 ELSE 0 END) serving,

SUM(CASE WHEN tickets.status='Completed' THEN 1 ELSE 0 END) completed

FROM departments

LEFT JOIN tickets
ON departments.id=tickets.department_id
AND tickets.booking_date='$date'

GROUP BY departments.id
";

$result=mysqli_query($conn,$sql);

$pdf->SetFont('Arial','',10);

while($row=mysqli_fetch_assoc($result))
{

$pdf->Cell(55,10,$row['department_name'],1);

$pdf->Cell(27,10,$row['total'],1);

$pdf->Cell(27,10,$row['waiting'],1);

$pdf->Cell(27,10,$row['serving'],1);

$pdf->Cell(27,10,$row['completed'],1);

$pdf->Ln();

}

$pdf->Ln(10);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(190,10,'Doctor Summary',0,1);

$pdf->SetFont('Arial','B',9);

$pdf->Cell(45,10,'Doctor',1);
$pdf->Cell(45,10,'Department',1);
$pdf->Cell(25,10,'Patients',1);
$pdf->Cell(25,10,'Waiting',1);
$pdf->Cell(25,10,'Serving',1);
$pdf->Cell(25,10,'Completed',1);

$pdf->Ln();

$sql = "
SELECT
doctors.fullname,
departments.department_name,

COUNT(tickets.id) total,

SUM(CASE WHEN tickets.status='Waiting' THEN 1 ELSE 0 END) waiting,

SUM(CASE WHEN tickets.status='Serving' THEN 1 ELSE 0 END) serving,

SUM(CASE WHEN tickets.status='Completed' THEN 1 ELSE 0 END) completed

FROM doctors

INNER JOIN departments
ON doctors.department_id = departments.id

LEFT JOIN tickets
ON doctors.id = tickets.doctor_id
AND tickets.booking_date='$date'

GROUP BY doctors.id
";

$result = mysqli_query($conn,$sql);

$pdf->SetFont('Arial','',9);

while($row=mysqli_fetch_assoc($result))
{
    $pdf->Cell(45,10,$row['fullname'],1);
    $pdf->Cell(45,10,$row['department_name'],1);
    $pdf->Cell(25,10,$row['total'],1);
    $pdf->Cell(25,10,$row['waiting'],1);
    $pdf->Cell(25,10,$row['serving'],1);
    $pdf->Cell(25,10,$row['completed'],1);

    $pdf->Ln();
}

$pdf->Ln(10);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(190,10,'Patient Details',0,1);

$pdf->SetFont('Arial','B',8);

$pdf->Cell(40,10,'Patient',1);
$pdf->Cell(20,10,'Ticket',1);
$pdf->Cell(40,10,'Department',1);
$pdf->Cell(35,10,'Doctor',1);
$pdf->Cell(25,10,'Status',1);
$pdf->Cell(30,10,'Queue',1);

$pdf->Ln();

$sql = "
SELECT
patients.fullname,
tickets.ticket_number,
departments.department_name,
doctors.fullname AS doctor_name,
tickets.status,
tickets.queue_position

FROM tickets

INNER JOIN patients
ON tickets.patient_id = patients.id

INNER JOIN doctors
ON tickets.doctor_id = doctors.id

INNER JOIN departments
ON tickets.department_id = departments.id

WHERE tickets.booking_date='$date'

ORDER BY
departments.department_name,
tickets.queue_position ASC
";

$result = mysqli_query($conn,$sql);

$pdf->SetFont('Arial','',8);

while($row = mysqli_fetch_assoc($result))
{

$pdf->Cell(40,8,$row['fullname'],1);

$pdf->Cell(20,8,$row['ticket_number'],1);

$pdf->Cell(40,8,$row['department_name'],1);

$pdf->Cell(35,8,$row['doctor_name'],1);

$pdf->Cell(25,8,$row['status'],1);

$pdf->Cell(30,8,$row['queue_position'],1);

$pdf->Ln();

}
$pdf->Ln(10);

$pdf->SetFont('Arial','I',9);

$pdf->Cell(
190,
8,
'Generated on: '.date("Y-m-d H:i:s"),
0,
1,
'R'
);

$pdf->Output();
?>


