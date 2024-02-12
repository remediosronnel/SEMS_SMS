<?php 
session_start();


$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";
$orgID = "";

$conn = new mysqli($sname, $uname, $password, $db_name);

$studentID = $_SESSION['studentID'];


if (isset($_SESSION['studentID']) && isset($_SESSION['userName'])) {
    
    $sql = "SELECT * FROM studentorgtable WHERE studentorgtable.studentID = '$studentID'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $orgID = $row['org1'];
    $_SESSION['orgID'] = $row['org1'];
    $_SESSION['studentID'] = $row['studentID'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<title>HOME</title>
	<link rel="stylesheet" href="style1.css">
    <script src="https://kit.fontawesome.com/14c66978a0.js" > crossorigin='anonymous'</script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        .circular--landscape { 
            display: inline-block;
            position: relative; 
            width: 100px; 
            height: 100px; 
            overflow: hidden; 
            border-radius: 50%; }
        .circular--landscape img { 
            width: auto; 
            height: 100%; 
            margin-left: 10px; 
            margin-right: 10px;
        }
    </style>
     <style>
        /* Style the colored dropdown container */
        .colored-dropdown {
            position:inherit;
            display:inline-block;
            padding-right: 120px;
        }

        /* Style the colored dropdown button */
        .colored-dropbtn {
            background-color: #3498db;
            color: white;
            padding: 10px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            width: 150px;
        }

        /* Style the colored dropdown content (hidden by default) */
        .colored-dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            width: 100px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        /* Style the links inside the colored dropdown */
        .colored-dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Change color on hover */
        .colored-dropdown-content a:hover {
            background-color: #3498db;
            color: white;
        }

        /* Show the colored dropdown content when the button is clicked */
        .colored-dropdown:hover .colored-dropdown-content {
            display: block;
        }

        .main--content{
            position: relative;
            background-color: #ebe9e9;
            width: 100%;
            padding: 1rem;
        
        }

        
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo"></div>
        <ul class="menu">
            <li class="active">
                <a href="home.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>DASHBOARD</span>
                </a>
            </li>     
            <li>
                <a href="student_attendance.php">
                    <i class="fa-solid fa-check"></i>
                    <span>ATTENDANCE</span>
                </a>
            </li>
            <li>
                <a href="generate_qr.php">
                    <i class="fa-solid fa-paperclip"></i>
                    <span>GENERATE QR</span>
                </a>
            </li>
            <li>
                <a href="profile.php">
                    <i class="fa-solid fa-user"></i>
                    <span>PROFILE</span>
                </a>
            </li>           

            <li >
                <a href="#" id="logout" onclick="confirmLogout()">
                    <i class="fa-solid fa-xmark"></i>
                    <span>LOGOUT</span>
                </a>
            </li>
           
        </ul>
    </div>
<!-- dashboard area -->
    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
                <!-- <span>PRIMARY</span> -->
                <h1>DASHBOARD</h1>
            </div>
        <div class="user--info">
            <div class="search-box">
                <h5><?php  echo $row['firstName']." ".$row['middleName']." ".$row['lastName']     ?></h5>
            </div>

            <div class="colored-dropdown">
        <button class="colored-dropbtn"> MENU </button>
        <div class="colored-dropdown-content">
            <a href="file_upload.php" style="background-color: #3498db;"> ORG OFFICERS </a>
           
            
           
        </div>
            </div>
       
            </div>
        </div>
<?php


$conn = mysqli_connect($sname, $uname, $password, $db_name);

$sql = "SELECT count(*) FROM rsotable";
$result = $conn -> query($sql);

?>
<?php
 $sql1 = "SELECT * FROM eventtable WHERE eventtable.orgID = '$orgID'";
 $result1 = $conn -> query($sql1);
if ($result1->num_rows > 0) {
   ?>
    

<div class="card--container">        
    <div class="card--wrapper">
    <h4>OFFICERS</h4>

<div class="payment--card light-red">
    <div class="card--header" style="display: flex; justify-content: space-around;">
        <?php    
   
        $sql4 = "SELECT * FROM officertable where orgID = '$orgID'";
        $result4 = $conn->query($sql4);

        while ($row4 = $result4->fetch_assoc()) {
            $offName = $row4["officer_name"];
            $offPosition = $row4["officer_position"];
            $offImage = $row4["image_path"];
          
          

            echo "<div style='text-align: center;'>";
            echo "<div class='circular--landscape'>";
            echo "<img src='/SSG/RSO/img/RSO_image/$offImage' />";
            echo "</div>";
            echo "<p>$offName</p>";
            echo "<p>$offPosition</p>";
            echo "</div>";     
            // Repeat the same pattern for other officers
        
    }
        ?>
    </div>
</div>
<break>
<break>
<break>
<br>
<br>
<br>
<br>
<br>
<br> 
<p>RSO ANNOUNCEMENTS</p>     
<break>
<br>
<?php
$sql = "SELECT org1 FROM studentorgtable WHERE studentorgtable.studentID = '$studentID'";
$result = mysqli_query($conn, $sql);
    
    while($row = mysqli_fetch_assoc($result)){
    $orgID = $row['org1'];

    $sql1 = "SELECT * FROM eventtable WHERE eventtable.orgID = '$orgID'";
    $result1 = $conn -> query($sql1);

?>
   
<?php   while ($row1 = $result1->fetch_assoc()) {
?>
    <div class="card-wrapper">
                <div class="payment--card light-red" >
                    <div class="card--header">
                        <div class="amount">
                            <span class="title">
                                <?php 
                                    echo "ORG NAME:"." ".$row1['orgName'];
                                    echo "<strong><h3>On Going Event: ".$row1["eventDescription"] ."</h3></strong>".
                                    "Event Date: ".$row1["eventDate"]." ".$row1['eventTime'];
                                   
                                ?>
                            </span>
                            <span class="amount-value">
                               
                            </span> 
                        </div>
                            <i class="fa-solid fa-info icon"> </i>
                    </div>
                    <span class="card-detail"> 
                    </span>
                </div> 
             </div>    
      <br>


<?php
    }
}
}
?>
<br>
<br>
<?php
$sql2 = "SELECT * FROM eventtable WHERE eventtable.orgID = '0'";
 $result2 = $conn -> query($sql2);
if ($result2->num_rows > 0) {
    
    echo "<p>SSG ANNOUNCEMENTS</p>";
    while ($row2 = $result2->fetch_assoc()) {
?>
     
            <div class="card-wrapper">
                <div class="payment--card light-red" >
                    <div class="card--header">
                        <div class="amount">
                            <span class="title">
                                <?php 
                                    echo "<strong><h3>On Going Event: ".$row2["eventDescription"] ."</h3></strong>".
                                    "Event Date: ".$row2["eventDate"]."  ".$row2["eventTime"];
                                ?>
                            </span>
                            <span class="amount-value">
                               
                            </span> 
                        </div>
                            <i class="fa-solid fa-info icon"> </i>
                    </div>
                    <span class="card-detail"> 
                    </span>
                </div>
                <br>
                <br>              
        <?php
                }
                }
$conn->close();
?>
                </div>  
          
<?php

}else{
     header("Location: index.php");
     exit();
}
 ?>

<script src="sweetalert.min.js"></script>
                <script>
                         function confirmLogout() {
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: 'You will be logged out',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, logout!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // If user confirms, redirect to logout page or perform logout action
                                        window.location.href = 'logout.php'; // Change the URL to your logout script
                                    }
                                });
                            }         
                </script>
   
</body>
</html>