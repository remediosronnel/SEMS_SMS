<?php 
session_start();
$orgID = $_SESSION['orgID'];
$_SESSION['orgID'] = $orgID;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RSO LIST</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">"
    <style>
            *{
                background-color: aqua;
              
            }
            table{
                display: inline-block;
                position: inherit;
                table-layout: fixed;

            }
            th, td {
              padding: 15px;
              text-align: center;
              border: black solid 1px;
              
            }


    </style>
</head>
<body>
    
    <a id="save_to_image"> 
    <div class="invoice-container">
        <div class="container my-5"> 
        <p><strong> ORG EVENT </strong></p>
    <table  width="900" cellpadding="1" cellspacing="1">
        <thead>
            <tr>
                    <th>Event ID</th>
                    <th>Org Name</th>
                    <th style="width:43%" span="3">Event Description</th>
                    <th>Event Date</th>
                    <th>Event Time</th>
                    <th>QR Code</th>  
            </tr>
        </thead>

            <?php
                            
            $sname = "127.0.0.1";
            $uname = "root";
            $password = "";
            $db_name = "lazaca";

            $conn = new mysqli($sname, $uname, $password, $db_name);

            if (!$conn) {
                echo "Connection failed!";
            }
            $sql = "SELECT * FROM eventtable WHERE orgID = '$orgID'";
            $result = $conn->query($sql);

            if(!$result){
                die("Invalid query: " .$conn->error);
            }
            while($row = $result->fetch_assoc()){
                echo "
                    <tr>

                    <td>$row[eventID]</td>
                    <td>$row[orgName]</td>
                    <td>$row[eventDescription]</td>
                    <td>$row[eventDate]</td>
                    <td>$row[eventTime]</td>
                    <td>
                    <a class='btn btn-primary btn-sm' href='generate_qr.php?eventID=$row[eventID]'>Generate QR</a>
                    </td>
                    </tr> 
                    ";
            }
            ?>
    </tbody>

    </table>


    </a>

    <a id="save_to_image"> 
    <div class="invoice-container">
        <div class="container my-5"> 
        <p><strong>SSG EVENT</strong></p>
    <table  width="900" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                    <th>Event ID</th>
                    <th>Org Name</th>
                    <th >Event Description</th>
                    <th>Event Date</th>
                    <th>Event Time</th>
                    <th>QR Code</th>  
            </tr>
        </thead>

            <?php
                            
            $sname = "127.0.0.1";
            $uname = "root";
            $password = "";
            $db_name = "lazaca";

            $conn = new mysqli($sname, $uname, $password, $db_name);

            if (!$conn) {
                echo "Connection failed!";
            }
            $sql = "SELECT * FROM eventtable WHERE orgID = '0'";
            $result = $conn->query($sql);

            if(!$result){
                die("Invalid query: " .$conn->error);
            }
            while($row = $result->fetch_assoc()){
                echo "
                    <tr>

                    <td>$row[eventID]</td>
                    <td>$row[orgName]</td>
                    <td>$row[eventDescription]</td>
                    <td>$row[eventDate]</td>
                    <td>$row[eventTime]</td>
                    <td>
                    <a class='btn btn-primary btn-sm' href='generate_qr.php?eventID=$row[eventID]'>Generate QR</a>
                    </td>
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
    <a class='btn btn-primary btn-sm' style="position: absolute; left: 750px;" href='home.php' > CANCEL </a>
        <script src="html2canvas.js"></script>
        <script src="rso_list.js"></script>
   
</body>

</html>