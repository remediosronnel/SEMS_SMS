<?php session_start();       

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$orgID = $_SESSION['orgID'];
$conn = new mysqli($sname, $uname, $password, $db_name);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RSO Event</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <main class="table" id="customers_table">
        <section class="table__header">
            <h1>EVENT LIST</h1>
            <div class="input-group">
                <input type="search" placeholder="Search Data...">
               
            </div>
           
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Event ID <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Recipient <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Org Name <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Event Description <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Event Date<span class="icon-arrow">&UpArrow;</span></th>
                        <th> Attendance<span class="icon-arrow">&UpArrow;</span></th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                    $sql = "SELECT * FROM eventtable WHERE eventtable.orgID = '$orgID'";
                    $result = $conn->query($sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php  echo $row['eventID']       ?></td>
                        <td> <?php  echo $row['recePient']         ?></td>
                        <td> <?php  echo $row['orgName']         ?></td>
                        <td> <?php  echo $row['eventDescription']         ?> </td>
                        <td> <?php  echo $row['eventDate']?> </td>
                        <?php          $r=$row['eventID'];       ?>
                        <td>  <a class='btn btn-primary btn-sm' href='attendance/attendance.php?r=$r'> <button>OPEN</a> </button>                               </td>
                    </tr>
                    <?php   }  ?>
                    <tr><a href="home.php" class="fcc-btn"> BACK </a></tr>
                    <tr><a href="Announcement/event.php" class="fcc-btn"> CREATE EVENT </a></tr>
                </tbody>
            </table>
          
        </section>
        
    </main>
    <script src="script.js"></script>
    
</body>

</html>