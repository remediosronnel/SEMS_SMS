<?php
session_start();  
include("dbconnect.php");
$orgID = isset($_GET['recePient']) ? $_GET['recePient'] : '';

$conn = mysqli_connect("127.0.0.1", "root", "", "lazaca");
if (!$conn) {
	echo "Connection failed!";
} 

// Perform a query to fetch student contact numbers
    $sql = "SELECT contactNo FROM studenttable WHERE studenttable.orgID = '$orgID'"; // Replace 'students' with your actual table name
    $result = mysqli_query($conn, $sql);

if ($result) {
    $data = array(); // Initialize an array to hold the fetched data

    // Fetch data from the result set and store it in the array
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row; // Add each row as an element to the data array
    }

    // Return the data as JSON format
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo "Error executing query: " . mysqli_error($conn);
}

// Close the database connection if necessary
mysqli_close($conn);
?>
