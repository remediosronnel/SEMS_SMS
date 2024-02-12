<?php
session_start();
include "db_conn.php";

if (!isset($_SESSION['orgID'])) {
    echo "Error: Organization ID is not set in the session.";
    exit();
}

$orgID = $_SESSION['orgID'];
$studentID = $_POST['studentID'];

$checkDuplicateQuery = "SELECT COUNT(*) AS count FROM studentorgtable WHERE studentID = ? AND org1 = ?";
$checkDuplicateStmt = $conn->prepare($checkDuplicateQuery);
$checkDuplicateStmt->bind_param("ii", $_POST['studentID'], $orgID);
$checkDuplicateStmt->execute();
$result = $checkDuplicateStmt->get_result();
$row = $result->fetch_assoc();
$count = $row['count'];

$checkDuplicateStmt->close();

if ($count > 0) {
    echo "Error: Student already exists in the organization.";
    exit();
}

// Determine which org column to use
$orgColumns = ['org1', 'org2', 'org3', 'org4', 'org5'];
$orgToUse = null;

foreach ($orgColumns as $orgColumn) {
    if (empty($orgToUse) && empty($row[$orgColumn])) {
        $orgToUse = $orgColumn;
    }
}

if (!empty($orgToUse)) {
    $sql = "INSERT INTO studentorgtable (studentID, idNumber, firstName, middleName, lastName, courseS, yearLevel, contactNo, $orgToUse) 
            SELECT studentID, idNumber, firstName, middleName, lastName, courseS, yearLevel, contactNo, ? 
            FROM studenttable 
            WHERE studentID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $orgID, $_POST['studentID']); 

    if ($stmt->execute()) {
        // Additional code after the insertion
        $sql1 = "SELECT * FROM studentorgtable WHERE studentID = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("i", $_POST['studentID']);
        $stmt1->execute();
        $result1 = $stmt1->get_result();

        while($row1 = $result1->fetch_assoc()) {
            logActivity($orgID, $date, 'Add', 'User Added ' . $row1['firstName'] . ' ' . $row1['middleName'] . ' ' . $row1['lastName'], $time);
        }

        $stmt1->close();
        
        header("Location: add_student.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Error: No available org column to use.";
}

$conn->close();

