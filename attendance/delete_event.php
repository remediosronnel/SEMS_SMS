<?php 
include "dbconnect.php";

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = new mysqli($sname, $uname, $password, $db_name);

if(isset($_GET["eventID"])){
    $eventID = $_GET["eventID"];


$sql = "SELECT * FROM eventtable WHERE eventtable.eventID = $eventID";
$result = $conn ->query($sql);
$row = $result->fetch_assoc();
$recepientType = $row['recepientType'];

$sql = "DELETE FROM eventtable WHERE eventtable.eventID = '$eventID'";
$conn ->query($sql);
   
logActivity('0', $date, 'Delete', 'User deleted the event for '."$recepientType", $time);
}

header("location: show_attendance.php");
exit; 
?>