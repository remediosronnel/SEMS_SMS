<?php 
session_start();


$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";
$orgID = "";

$conn = new mysqli($sname, $uname, $password, $db_name);




if (isset($_SESSION['studentID']) && isset($_SESSION['userName'])) {

    $studentID = $_SESSION['studentID'];
    
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
        .officers-container {
            display: flex;
            flex-wrap: wrap; /* Allow wrapping of items */
        }

        .officer {
            flex: 0 0 auto; /* Allow items to grow and shrink according to content */
            width: 200px; /* Set width of each officer */
            margin-right: 20px; /* Adjust spacing between officers */
            margin-bottom: 20px; /* Adjust spacing between rows */
        }

        .officer-image {
            width: 100%; /* Ensure image fills the container */
            border-radius: 50%; /* Make image circular */
            border: 3px solid #fff; /* Add a border around the image */
        }

        .officer-name,
        .officer-position {
            display: block; /* Ensure text appears on new lines */
            text-align: center; /* Center align text */
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
    $sql5 = "SELECT * FROM officertable where orgID = '0'";
    $result5 = $conn -> query($sql5);
   

?>

        <div class="tabular--wrapper">
            <h3 class="main--tile"></h3>
            <div class="table-container">

               <?php 
               while ($row5 = mysqli_fetch_assoc($result5)) {
                   $image = $row5['image_path'];
                   echo "<div style='display: inline-block; text-align: center; margin-right: 20px;'>";
                   echo "<img src='/SSG/img/$image' width='75' height='75' title='$image'>";
                   echo '<br>';
                   echo $row5['officer_name'];
                   echo '<br>';
                   echo $row5['officer_position'];
                   echo "</div>";
               }
               
            ?>
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


   
<?php
}
// Assuming $studentID is already defined
$sql_orgs = "SELECT DISTINCT org1 FROM studentorgtable WHERE studentorgtable.studentID = '$studentID'";
$result_orgs = mysqli_query($conn, $sql_orgs);
echo '<p>RSO ANNOUNCEMENTS</p>';
// Check if there are any organizations for the student
if (mysqli_num_rows($result_orgs) > 0) {
    while ($row_org = mysqli_fetch_assoc($result_orgs)) {
        $orgID1 = $row_org['org1'];

        // Fetch events for each organization
        $sql_events = "SELECT * FROM eventtable WHERE eventtable.orgID = '$orgID1'";
        $result_events = mysqli_query($conn, $sql_events);

        // Check if there are events for the current organization
        if (mysqli_num_rows($result_events) > 0) {
            while ($row_event = mysqli_fetch_assoc($result_events)) {
                ?>
                <div class="card-wrapper">
                    <div class="payment--card light-red">
                        <div class="card--header">
                            <div class="amount">
                                <span class="title">
                                    <?php 
                                        echo "ORG NAME: ".$row_event['orgName']."<br>";
                                        echo "<strong>On Going Event: ".$row_event['eventDescription']."</strong><br>".
                                             "Event Date: ".$row_event['eventDate']." ".$row_event['eventTime'];   
                                    ?>
                                </span>
                                <span class="amount-value">
                                    <!-- Additional content -->
                                </span> 
                            </div>
                            <i class="fa-solid fa-info icon"> </i>
                        </div>
                        <span class="card-detail"> 
                            <!-- Additional content -->
                        </span>
                    </div> 
                </div>    
                <br>
                <?php
            }
        }
    }

} else {

}

?>

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