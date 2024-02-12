<?php
// Establish database connection
$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = new mysqli($sname, $uname, $password, $db_name);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch events from the database
$sql = "SELECT eventID FROM attentable WHERE orgID = '0'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Initialize an empty array to store the fetched data
    $events = array();

    // Fetch associative array
    while ($row = $result->fetch_assoc()) {
        // Add each row to the $events array
        $events[] = $row;
    }

    // Convert the array to JSON format and output it
    echo json_encode($events);
} else {
    // If no events found, return an empty JSON array
    echo json_encode(array());
}

// Close database connection
$conn->close();
