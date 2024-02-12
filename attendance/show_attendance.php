<?php 
session_start();       
$i=0;
$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = new mysqli($sname, $uname, $password, $db_name);

if(isset($_SESSION['orgID'])) {
    $orgID = $_SESSION['orgID'];
    $sql = "SELECT * FROM eventtable WHERE orgID = '0'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
}

$eventID = "";

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
          td{
            text-align: center;
        }
    </style>
</head>

<body>
    <main class="table" id="customers_table">
        <section class="table__header">
            <h1>EVENT LIST</h1>
            <div class="export__file">
                <label for="export-file" class="export__file-btn" title="Export File"></label>
                <input type="checkbox" id="export-file">
                
            </div>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Event ID </th>
                        <th> Recipient </th>
                        <th> Org Name </th>
                        <th> Event Description </th>
                        <th> Event Date </th>
                        <th> Event Time </th>
                        <th> Feedbacks</th>
                        <th> Action </th>
                        <th> Attendance </th>
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
                        
                     
                    $sql1 = "SELECT * FROM attentable WHERE orgID = '$orgID'";
                    $result1 = $conn->query($sql1);
                    $row1 = mysqli_fetch_assoc($result1);

                    
                    ?>   
                    
                    <tr>
                        <td><?php  echo $i  ?></td>
                        <td> <?php  echo $row['recePient']         ?></td>
                        <td> <?php  echo $row['orgName']         ?></td>
                        <td> <?php  echo $row['eventDescription']         ?> </td>
                        <td> <?php  echo $row['eventDate']         ?> </td>
                        <td> <?php  echo  $time  ?>             </td>
                        <td> 
                <?php    if(empty($row1['satRate']) AND empty($row1['satRate'])) {          ?>
                <?php       }else{        ?>     
                    <a class='btn btn-primary btn-sm' href="SSG_feedback.php?eventID=<?php echo $row['eventID'];?>">Feedback</a>
                    <?php }?>
                        </td>
                        <td>
                        
                        <a class='btn btn-primary btn-sm' href="edit_event.php?eventID=<?php echo $row['eventID'];?>">EDIT</a>
                        <a class='btn btn-danger btn-sm' href='delete_event.php?eventID=<?php echo $row['eventID']; ?>'> DELETE </a>
                        </td>

                        
                        <form method="post" Action="attendance.php">
                            <input type="hidden" id="eventID" name="eventID" value="<?php echo $row['eventID'] ?>">
                            <input type="hidden" id="orgID" name="orgID" value="<?php echo $row['orgID']?>">
                        </form>
                       
                        
                        <td> <a class='btn btn-primary btn-sm' href='attendance.php?eventID=<?php echo $row['eventID'];?>'>OPEN</a></td>
                        
                    </tr>
                    <?php   }  ?>
                    <tr><a href="/SSG/home.php" class="fcc-btn"> BACK </a></tr>
              
                </tbody>
            </table>
          
        </section>
        
    </main>

    
</body>

</html>