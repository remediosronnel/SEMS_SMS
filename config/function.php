<?php
session_start();

require 'db_conn.php';

function validate($inputData){
    global $conn;

    $validatedData = mysqli_real_escape_string($conn, $inputData);
    return trim($validatedData);
}




function redirect($url, $status){
    $_SESSION['status'] = $status;
    header('Location'. $url);
    exit(0); 
}


function getCount($tableName)
{
    global $conn;

    $table = validate($tableName);
    $query = "SELECT * FROM $table";
    $result = mysqli_query($conn, $query);
    $totalCount = mysqli_num_rows($result);
    return $totalCount;

}



?>