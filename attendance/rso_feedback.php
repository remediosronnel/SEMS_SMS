<?php 
session_start();
$orgID = isset($_GET['orgID']);

$conn = new mysqli("127.0.0.1", "root", "", "lazaca");

if (isset($_GET["eventID"]) && $_GET["eventID"]){
    
    $eventID = $_GET['eventID'];
    $sql = "SELECT * FROM rso_attentable  WHERE rso_attentable.eventID = '$eventID'";
    $result = $conn->query($sql);

  
     
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RSO Event</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
       
        td, th{
            text-align: center;
        }
        .btn{
           margin-left: 1000px;
        }
        @media print{
                body * {
                    visibility: hidden;
                }
                .print-container, .print-container * {
                    visibility: visible;
                }
        }

    </style>
</head>
<body>
<main class="table" id="table">
        <section class="print-container">
            <h1>EVENT FEEBACK</h1>
            <div class="export__file">
                
            </div>
        </section>
        <section class="table__body">
            <table class="print-container">
                <thead>
                    <tr>
                        <th width="5%"> Event ID </th>
                        <th width="15%">Event Name</th>
                        <th width="15%"> Rate </th>
                        <th width="30%"> Comment </th>
                       
                    </tr>
                </thead>

                <tbody>
                    <?php
                while($row = $result->fetch_assoc()){
                                
                                echo "
                                        <tr>
                                        <td>$row[eventID]</td>
                                        <td>$row[eventDescription]</td>
                                        <td>$row[satRate]</td>
                                        <td>$row[sugComment]</td>
                                        </tr> 
                                        ";
                             }   
                             
                             ?>
                    
                
                
                <a href="/SSG/attendance/show_attendance.php" class="fcc-btn"> BACK </a></tr>
                </tbody>
            </table>
         
        </section>
         <button onclick="window.print()" id="button" class="btn btn-primary">PRINT</button>
    </main>
   
</body>
</html>
