<?php
include "db_conn.php";
session_start();
$studentID = $_POST['studentID'];
$orgID = $_SESSION['orgID'];

$sql1 = "SELECT * FROM studentorgtable WHERE studentID = '$studentID'";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();


logActivity($orgID, $date, 'Delete', 'User deleted '.' '.$row1['firstName'].' '.$row1['middleName'].' '.$row1['lastName'], $time);



$sql = "DELETE FROM studentorgtable WHERE studentID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_POST['studentID']);

if ($stmt->execute()) {

  
    echo "Success";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
