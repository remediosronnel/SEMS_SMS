<?php
include "db_conn.php";

$userName = ""; 
$passWord = ""; 
$status = "Inactive";
$errorMessage = "";


$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";


$conn = new mysqli($sname, $uname, $password, $db_name);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET["studentID"])) {
    $studentID = $_GET["studentID"];

    $userName = ""; 
    $passWord = ""; 

    $sql = "SELECT * FROM studenttable where studentID = '$studentID'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    $studentName = $row['firstName'].' '.$row['middleName'].' '.$row['lastName'];

    
    $stmt = $conn->prepare("UPDATE studenttable SET userName = ?, passWord = ?, Status = ? WHERE studentID = ?");
    $stmt->bind_param("sssi", $userName, $passWord, $status, $studentID);

    logActivity('0', $date, 'Delete', 'User deactivated the account of '."$studentName", $time);
    if ($stmt->execute()) {
        header("Location: student.php");
        exit;
    } else {
        $errorMessage = "Invalid query: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
