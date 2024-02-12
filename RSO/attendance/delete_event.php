<?php 
include "db_conn.php";

// Establish database connection
$conn = new mysqli($sname, $uname, $password, $db_name);

// Check if eventID and orgID are set in the URL
if(isset($_GET['eventID']) && isset($_GET['orgID'])){
    $eventID = $_GET['eventID'];
    $orgID = $_GET['orgID'];

    // Select the organization information
    $sql1 = "SELECT * FROM rsotable WHERE rsotable.orgID = '$orgID'";
    $result1 = $conn->query($sql1);

    // Check if the organization exists
    if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();
        $orgName = $row['orgName'];

        // Delete the event from eventtable
        $sql = "DELETE FROM eventtable WHERE eventtable.eventID = '$eventID'";
        if ($conn->query($sql) === TRUE) {
            // Log activity
            logActivity($orgID, $date, 'Delete', 'User deleted the event of ' . $orgName, $time);
        } else {
            echo "Error deleting event: " . $conn->error;
        }
    } else {
        echo "Organization not found";
    }
}

// Redirect to show_attendance.php
header("Location: show_attendance.php");
exit;
