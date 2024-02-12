<?php 
session_start();

if (isset($_SESSION['ssgID']) && isset($_SESSION['orgID'])) {


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
        /* Style the colored dropdown container */
        .colored-dropdown {
            position: relative;
            display: inline-block;
        }

        /* Style the colored dropdown button */
        .colored-dropbtn {
            background-color: #3498db;
            color: white;
            padding: 10px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        /* Style the colored dropdown content (hidden by default) */
        .colored-dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
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
                <a href="config/event.php">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>ANNOUNCEMENT</span>
                </a>
            </li>
            <li>
                <a href="rso.php">
                    <i class="fa-solid fa-list-check"></i>
                    <span>RSO MANAGEMENT</span>
                </a>
            </li>
            <li>
                <a href="student.php">
                    <i class="fa-solid fa-people-roof"></i>
                    <span>STUDENT MANAGEMENT</span>
                </a>
            </li>
            <li>
                <a href="attendance/show_attendance.php">
                    <i class="fa-solid fa-check"></i>
                    <span>ATTENDANCE</span>
                </a>
            </li>
            <li>
                <a href="generate_list.php">
                    <i class="fa-solid fa-paperclip"></i>
                    <span>GENERATE LIST</span>
                </a>
            </li>

            <form method="POST" action="logout.php" onsubmit="return submitForm(this);">
            <li >
                <a href="#" id="logout" onclick="confirmLogout()">
                    <i class="fa-solid fa-xmark"></i>
                    <span>LOGOUT</span>
                </a>
            </li>
            </form>
        </ul>
    </div>
<!-- dashboard area -->
    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
                <!-- <span>PRIMARY</span> -->
                <h1>ADMIN DASHBOARD</h1>
            </div>
        <div class="user--info">
        <div class="colored-dropdown">
        <button class="colored-dropbtn"> MENU </button>
        <div class="colored-dropdown-content">
            <a href="profile.php" style="background-color: #3498db;"> UPDATE </a>
            <a href="activity_log.php" style="background-color: #3498db;"> HISTORY </a>
            <a href="event_list.php" style="background-color: #3498db;"> ATTENDANCE LIST </a>
            <a href="officers.php" style="background-color: #3498db;"> OFFICERS </a>
           
        </div>
    </div>
        <img src="ssg.png" alt=""/>
            </div>
        </div>

        
    <!-- CARD1 -->
<?php
$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

$sql = "SELECT count(*) FROM rsotable";
$result = $conn -> query($sql);


?>
        <div class="card--container">
            <h3 class="main--title">Today's Data</h3>
            <div class="card-wrapper">
                <div class="payment--card light-red" >
                    <div class="card--header">
                        <div class="amount">
                            <span class="title">
                                TOTAL RSO REGISTERED
                            </span>
                            <span class="amount-value"><h6>
                                <?php 
                                    $query = "SELECT * FROM rsotable";
                                    $result = mysqli_query($conn, $query);
                                    $totalCount = mysqli_num_rows($result); 
                                    echo $totalCount;   
                                ?>  </h6>
                            </span> 
                        </div>
                            <i class="fa-solid fa-user icon"> </i>
                    </div>
                    <span class="card-detail"> 
                    </span>
                </div>


                <div class="payment--card light-purple" >
                    <div class="card--header">
                        <div class="amount">
                            <span class="title">
                                TOTAL STUDENT ADDED
                            </span>
                            <span class="amount-value"><h6>
                                <?php 
                                    $query = "SELECT * FROM studenttable";
                                    $result = mysqli_query($conn, $query);
                                    $totalCount = mysqli_num_rows($result); 
                                    echo $totalCount;   
                                ?>  </h6>
                            </span> 
                        </div>
                            <i class="fa-regular fa-user icon"> </i>
                    </div>
                    <span class="card-detail"> 
                    </span>
                </div>

                <div class="payment--card light-purple" >
                    <div class="card--header">
                        <div class="amount">
                            <span class="title">
                                TOTAL ACTIVE STUDENT
                            </span>
                            <span class="amount-value"><h6>
                                <?php 
                                    $query = "SELECT * FROM studenttable WHERE studenttable.Status = 'Active'";
                                    $result = mysqli_query($conn, $query);
                                    $totalCount = mysqli_num_rows($result); 
                                    echo $totalCount;   
                                ?>  </h6>
                            </span> 
                        </div>
                            <i class="fa-regular fa-user icon"> </i>
                    </div>
                    <span class="card-detail"> 
                    </span>
                </div>
                              
            </div>
        
    </div>       

    <div class="tabular--wrapper">
            <h3 class="main--tile">RSO ANNOUNCEMENTS</h3>
            <div class="table-container">
                <table style="width: 100%;">
                    <thead>
                        
                        <tr>
                            <th>ORG NAME</th>
                            <th>EVENT DESCRIPTION</th>
                            <th>EVENT DATE</th>
                            <th>EVENT TIME</th>
                        </tr>
                        <tbody>
                        <?php
                        
                        $sql = "SELECT * FROM eventtable where orgID != '0'";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                        echo "
                            <tr>
                            <td>$row[orgName]</td>
                            <td>$row[eventDescription]</td>
                            <td>$row[eventDate]</td>
                            <td>$row[eventTime]</td>
                            </tr>
                            ";
                        }?>
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
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
                        
<?php

}else{
     header("Location: index.php");
     exit();
}
 ?>
    
</body>
</html>