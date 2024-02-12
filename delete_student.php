<?php 
include "db_conn.php";

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = new mysqli($sname, $uname, $password, $db_name);

if(isset($_GET['studentID'])){
    $studentID = $_GET['studentID'];

$query = "SELECT * FROM studenttable where studentID = '$studentID'";
$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);
$studentName = $row["firstName"].' '.$row["middleName"].' '.$row["lastName"];

$sql = "DELETE FROM studenttable WHERE studentID = '$studentID'";
$conn ->query($sql);

logActivity('0', $date, 'Delete', 'User deleted '."$studentName".'from the record', $time);

}

$conn    -> close();

header("location: student.php");
exit; 
