<?php

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";


$conn = new mysqli($sname, $uname, $password, $db_name);


if(isset($_POST['orgID'])) {
    $orgID = $_POST['orgID'];

    
    $query = "SELECT typeRSO FROM rsotable WHERE rsotable.orgID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $orgID); 

  
    $stmt->execute();
    $result = $stmt->get_result();

    
    $options = '<option value="">Select RSO Type</option>';
    while ($row = $result->fetch_assoc()) {
        if(empty(!$row)){
        $options .= "<option value='{$row['typeRSO']}'>{$row['typeRSO']}</option>";
        }else{
            $options .= "<option value=''></option>";
        }

    }

    echo $options;
} else {
    echo "<option value=''>No types found</option>";
}
?>
