<?php
$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}

date_default_timezone_set('Asia/Manila');
$date = date('m-d-Y');
$time = date('h:i:s');

function logActivity($orgID, $date, $ActType, $ActDescription, $time) {
    $conn = new mysqli("127.0.0.1", "root", "", "lazaca");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $activityType = $conn->real_escape_string($ActType);
    $details = $conn->real_escape_string($ActDescription);

    $sql = "INSERT INTO activity_history (orgID, ActDate, ActType, ActDescription, ActTime) VALUES ('$orgID', '$date','$activityType', '$details', '$time')";
    $result = $conn->query($sql);

    $conn->close();

    if ($result) {
       
    } else {
        echo "Error logging activity: " . $conn->error;
    }
}




