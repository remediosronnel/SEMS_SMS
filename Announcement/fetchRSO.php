<?php
ini_set('display_errors',1);

include 'dbconnect.php';
$con = dbcon();

$k = $_POST["x"];
$sql = "SELECT * FROM studenttable WHERE studenttable.orgID = {$k}";
$result = mysqli_query($con, $sql);
while($rows = $result->fetch_assoc()) {
    $data['contactNo'] = $rows["contactNo"];

}

echo json_encode($data);


?>