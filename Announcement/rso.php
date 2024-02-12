<?php
session_start();
ini_set('display_errors',1);
include 'dbconnect.php';

$con = dbcon();
$sql = "SELECT rsotable.orgID FROM rsotable ";
$result = mysqli_query($con, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    
  <!-- Meta Tags -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <!-- Title -->
  <title>DOCUMENT</title>
  <script src= "js/emp.js"></script>
  <script src= "jquery.min.js"></script>
 
</head>
<body>
<form action="">
    <table>
        <tr>
            <td><strong>SELECT RSO ID</strong></td>
            <td>
                <select name= "empID" id= "empID" onchange= "fetchRso()">
                    <option value="">Select ID</option>
                    <?php 
                        while ($rows = mysqli_fetch_array($result)) {    
                            $k = $rows['orgID'];
                            echo '<option value="'.$k.'">'.$k.'</option>';

                        }
                    ?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td><strong>RSO NAME</strong></td>
            <td>
                <input type = "text" name = "orgName" id="orgName" size="40" value="<?php echo $rows['orgName']?>" >
            </td>
        </tr>
        <tr>
            <td><strong>FIRST NAME</strong></td>
            <td>
            <input type = "text" name = "firstName" id="firstName" size="40">
            </td>
        </tr>
        <tr>
            <td><strong>MIDDLE NAME</strong></td>
            <td>
            <input type = "text" name = "middleName" id="middleName" size="40">
            </td>
        </tr>
        <tr>
            <td><strong>LAST NAME</strong></td>
            <td>
            <input type = "text" name = "lastName" id="lastName" size="40">
            </td>
        </tr>
        <tr>
            <td><strong>POSITION</strong></td>
            <td>
            <input type = "text" name = "position" id="position" size="40">
            </td>
        </tr>
        <tr>
            <td><strong>CONTACT NUMBER</strong></td>
            <td>
            <input type = "text" name = "contactNo" id="contactNo" size="40">
            </td>
        </tr>
    </table>

</form> 





</body>
</html>
