<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();  
include 'db_conn.php';      

$i = 0;
$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";
$orgID = "";

$conn = new mysqli($sname, $uname, $password, $db_name);
$orgID = $_SESSION['orgID'];

$eventID = "";


logActivity($orgID, $date, 'Attendance', 'User attempting to open Attendance', $time);
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
</head>

<body>
    <main class="table" id="customers_table">
        <section class="table__header">
            <h1>EVENT LIST</h1>
            
           
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th style="width: 0.5em;"> Event ID</th>
                        <th> Recipient</th>
                        <th> Org Name</th>
                        <th> Event Description</th>
                        <th> Event Date</th>
                        <th> Event Time</th>
                        <th> Feedbacks</th>
                        <th> Action </th>
                        <th> Attendance</th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                    $sql = "SELECT * FROM eventtable WHERE eventtable.orgID = '$orgID'";
                    $result = $conn->query($sql);
                   
                    while ($row = mysqli_fetch_assoc($result)) {
                        $i++;
                        $eventTime = new DateTime($row['eventTime']);
                        $time = date_format($eventTime, "h:i:s");
                    ?>
                    <tr>
                        <td><?php echo $i;         ?></td>
                        <td> <?php  echo $row['recePient']         ?></td>
                        <td> <?php  echo $row['orgName']         ?></td>
                        <td> <?php  echo $row['eventDescription']         ?> </td>
                        <td> <?php  echo $row['eventDate']         ?> </td>
                        <td>   <?php  echo  $time  ?>  </td>
                        <td> 
                        <?php 
                            $eventID = $row['eventID'];
                            
                            $sql1 = "SELECT * from rso_attentable where eventID = '$eventID'";
                            $result1 = $conn->query($sql1);
                            $row1 = mysqli_fetch_assoc($result1);
                            if(empty($row1['satRate']) AND empty($row1['sugComment'])){                        ?>
                          
                            <?php } else{?>
                                <a class='btn btn-primary btn-sm' href="rso_feedback.php?eventID=<?php echo $row['eventID'];?>&orgID=<?php echo $row['orgID'];?>">Feedback</a> 
                            <?php }?>
                        </td>
                        
                        
                            <td>
                            <a class='btn btn-primary btn-sm' href='edit_event.php?eventID=<?php echo $row['eventID'];?>&orgID=<?php echo $row['orgID']?>'>EDIT</a>
                            
                            <a href='javascript:
                                swal({
                                title: "Delete selected item?",
                                text: "Unrecoverable Data",
                                icon: "warning",
                                buttons: true,
                                dangerMode: "true",
                                })
                                .then((willDelete) => {
                                if (willDelete) {
                                    swal({ title: "Delete Data Successfully",
                                    icon: "success"}).then(okay => {
                                    if (okay) {
                                        window.location.href = "delete_event.php?eventID=<?php echo $row['eventID'];?>&orgID=<?php echo $row['orgID']?>"; 
                                    }
                                    });
                                        
                                } else {
                                    swal({
                                    title: "Data Not Deleted",
                                    icon: "error",
                                    
                                    });
                                }
                                });'
                                class="btn btn-danger">Delete</a>

                        </td>

                      
                        <td> <button><a class='btn btn-primary btn-sm' href='/SSG/RSO/attendance/attendance.php?eventID=<?php echo $row['eventID'];?>&orgID=<?php echo $orgID ?>'> OPEN</a> </button></td>
                    </tr>
                    <?php   }  ?>
                    <tr><a href="/SSG/rso/home.php" class="fcc-btn"> BACK </a></tr>
                </tbody>
            </table>
          
        </section>
        
    </main>
    <script src="sweetalert.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
</body>

</html>