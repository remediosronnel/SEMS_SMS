<?php 
include "db_conn.php";

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = new mysqli($sname, $uname, $password, $db_name);

if(isset($_GET['orgID'])){
    $orgID = $_GET['orgID'];

$query = "SELECT * FROM rsotable WHERE orgID = '$orgID'";
$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);
$orgName = $row['orgName'];

$sql = "DELETE FROM rsotable WHERE orgID = '$orgID'";
$conn ->query($sql);
logActivity('0', $date, 'Delete', 'User deleted RSO '."$orgName", $time);

}

header("location: rso.php");
exit; 
?>