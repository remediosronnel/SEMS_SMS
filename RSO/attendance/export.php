<?php session_start();
include "db_conn.php";

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";
$orgID = $_SESSION['orgID'];
$eventID = $_SESSION['eventID'];
$i = 0;

$conn = new mysqli($sname, $uname, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$filename = "AttendanceRecord-".date('m-d-Y').".csv";
$query = "SELECT * FROM rso_attentable where eventID = '$eventID'";
$result = mysqli_query($conn, $query);
$array = array();

$query1 = "SELECT * FROM eventtable where eventtable.eventID = '$eventID'";
$result1 = mysqli_query($conn, $query1);
$array1 = array();

$file = fopen($filename,"w");
$array = array("ATTENDANCE ID","STUDENT NAME", "TIME OUT", "TIME OUT", "LOG DATE", "STATUS" );
$array1 = array("ORG NAME", "EVENT DESCRIPTION");

fputcsv($file, $array);
logActivity($orgID, $date, 'Generate', 'User generated attendance ', $time);

while($row = mysqli_fetch_array($result)){
    $i++;
    $ID = $i;
    $StudentName = $row['StudentName'];
    $TimeIn = $row['TimeIn'];
    $TimeOut = $row['TimeOut'];
    $LogDate = $row['LogDate'];
    $Status = $row['Status'];

    $array = array($ID, $StudentName, $TimeIn, $TimeOut, $LogDate, $Status);
    fputcsv($file, $array);
}

fputcsv($file, $array1);
$row1 = mysqli_fetch_array($result1) ;
    $orgName = $row1['orgName'];
    $eventDescription = $row1['eventDescription'];

    $array1 = array($orgName, $eventDescription);
    fputcsv($file, $array1);



fclose($file);

header("Content-Description: File Transfer");
header("Content-Disposition: Attachment; filename=$filename");
header("Content-type: application/csv;");
readfile($filename);
exit();

unlink($filename);

?>