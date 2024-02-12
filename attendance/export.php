<?php
session_start();
include 'dbconnect.php';

// Ensure session variables are set
if (!isset($_SESSION['orgID']) || !isset($_SESSION['eventID'])) {
    die("Session variables not set.");
}

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = new mysqli($sname, $uname, $password, $db_name);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$orgID = $_SESSION['orgID'];
$eventID = $_SESSION['eventID'];

$filename = "AttendanceRecord-" . date('m-d-Y') . ".csv";

// Fetch attendance records
$query = "SELECT * FROM attentable WHERE eventID = '$eventID'";
$result = mysqli_query($conn, $query);

// Create CSV file and write data
$file = fopen($filename, "w");
$array = array("ATTENDANCE ID", "STUDENT NAME", "TIME IN", "TIME OUT", "LOG DATE", "STATUS");

fputcsv($file, $array);
logActivity($orgID, $date, 'Generate', 'User generated attendance ', $time);


while ($row = mysqli_fetch_array($result)) {
    $ID = $row['attendanceID'];
    $StudentName = $row['StudentName'];
    $TimeIn = $row['TimeIn'];
    $TimeOut = $row['TimeOut'];
    $LogDate = $row['LogDate'];
    $Status = $row['Status'];

    $array = array($ID, $StudentName, $TimeIn, $TimeOut, $LogDate, $Status);
    fputcsv($file, $array);
}

fclose($file);

// Set headers for file download
header("Content-Description: File Transfer");
header("Content-Disposition: Attachment; filename=$filename");
header("Content-type: application/csv;");
readfile($filename);

// Delete the file after download
unlink($filename);
exit();

