<?php 
 include "db_conn.php"; 
 session_start();  
 $orgID = $_SESSION["orgID"];
$i = 0;
  
 $sname = "127.0.0.1";
 $uname = "root";
 $password = "";
 $db_name = "lazaca";

 $conn = new mysqli($sname, $uname, $password, $db_name);


 $sql = "SELECT * FROM studentorgtable where org1='$orgID'";
 $result = $conn->query($sql);
 if(!$result){
     die("Invalid query: " .$conn->error);
 }


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RSO LIST</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
</head>
<body>
    <a id="save_to_image"> 
    <div class="invoice-container">
        <div class="container my-5"> 
        <div class="logo" src="ssg.png"> 
            <img src="ssg.png" 
            style="width: 100px; height:100px"
            />
        </div>
    <table  cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Course</th>
                    <th>Year Level</th>
                    <th>Contact No</th>    
            </tr>
        </thead>

            <?php
            

            $orgID = $_SESSION['orgID'];

            if (!$conn) {
                echo "Connection failed!";
            }
            
            logActivity($orgID, $date, 'Navigation', 'User visited list of Members', $time);
            if(!$result){
                die("Invalid query: " .$conn->error);
            }
            while($row = $result->fetch_assoc()){
                $i++;
                echo "
                    <tr>

                    <td>$i</td>
                    <td>$row[firstName]</td>
                    <td>$row[middleName]</td>
                    <td>$row[lastName]</td>
                    <td>$row[courseS]</td>
                    <td>$row[yearLevel]</td>
                    <td>$row[contactNo]</td>
                    <td>                 </td>
                    </tr> 
                    ";
            }
            ?>
    </tbody>

    </table>


    </a>
        
    
    </div>           
</div>
</div>
    <div class = "buttons-container">
        
        <button id="print">Print</button>
        <button id="cancel">Cancel</button>
    </div>
        <script src="html2canvas.js"></script>
        <script src="rso_list.js"></script>
   
</body>

</html>