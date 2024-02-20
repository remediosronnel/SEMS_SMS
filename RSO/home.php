<?php 
session_start();

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$typeRSO = "";
$orgName = "";
$orgID = "";

$conn = new mysqli($sname, $uname, $password, $db_name);

if (!$conn) {
    echo "Connection failed!";
}

if (isset($_SESSION['orgID']) && isset($_SESSION['userName']) && isset($_SESSION['typeRSO'])) {

    $orgID = $_SESSION['orgID'];
    $typeRSO = $_SESSION['typeRSO'];
    
    $sql = "SELECT * FROM rsotable WHERE rsotable.orgID = '$orgID'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rsotable WHERE rsotable.orgID = $orgID"));

    $id = $user["orgID"];
    $name = $user["orgName"];
    $image = $user["image"];

    // Get the image URL
    $imageUrl = "img/$image";
}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vibrant.js/2.1.0/Vibrant.min.js"></script>

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
        <div class="logo">
        
        </div>
        <ul class="menu">
            <li class="active">
                <a href="home.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>DASHBOARD</span>
                </a>
            </li>
            <li>
                <a href="Announcement/event.php">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>ANNOUNCEMENT </span>
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
                <a href="profile.php">
                    <i class="fa-solid fa-user"></i>
                    <span>PROFILE</span>
                </a>
            </li>
        
        <form id="logoutForm" method="POST" action="logout.php" onclick="return confirmLogout()">
         
                <li>
                    <a href="#" id="logout">
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
                <h1>DASHBOARD</h1>
            </div>
        <div class="user--info">
       
            <div class="search-box">
            <div class="colored-dropdown">

        <button class="colored-dropbtn"> MENU </button>
        <div class="colored-dropdown-content">
            <a href="event_list.php" style="background-color: #3498db;"> ATTENDANCE LIST </a>
            <a href="activity_log.php" style="background-color: #3498db;"> HISTORY </a>
            <a href="student_list.php" style="background-color: #3498db;"> STUDENT </a>
            <a href="announcement_list.php" style="background-color: #3498db;"> ANNOUNCEMENT </a>
            <a href="officers.php" style="background-color: #3498db;"> ORG OFFICERS </a>
        </div>
            </div>









            <?php 


                $image = $row['image'];
                if(!empty($image)){ ?>

                    <img src="img/<?php echo $image; ?>" width="25" height="25" title="<?php echo $image; ?>" id="previewImage">

            <?php
                }else{?>

                    <img src="img/Upload_logo.png" width="25" height="25" title="<?php echo $image; ?>" id="previewImage">
            <?php
                }
            ?>
            <script>
                // Get the $image variable from PHP and inject it into CSS
                <?php if (!empty($image)): ?>
                var backgroundImage = "url('img/<?php echo $image;?>')";
                var style = document.createElement('style');
                style.innerHTML = `
                    .main--content {
                        position: relative;
                        background-color: #ebe9e9;
                        width: 100%;
                        padding: 1rem;
                        background-image: ${backgroundImage};
                        background-size: cover; /* Set background size to cover */
                        background-position: center;
                    }
                `;
                document.head.appendChild(style);
                <?php endif; ?>
            </script>                      
            
            </div>
            <h5><?php echo "WELCOME &nbsp;&nbsp;&nbsp;&nbsp;".$row['orgName']   ?></h5>

            </div>
        </div>

        <?php
    $sql5 = "SELECT * FROM officertable where orgID = '0'";
    $result5 = $conn -> query($sql5);
    

?>
        <div class="tabular--wrapper">
            <h3 class="main--tile"></h3>
            <div class="table-container">

            <P>SSG OFFICERS </P>
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
<br>

        
    <!-- CARD1 -->
<?php

$sql = "SELECT count(*) FROM studenttable";
$result = $conn -> query($sql);


?>
        <div class="card--container">
            <h3 class="main--title">Member's Data</h3>
            <div class="card-wrapper">
                <div class="payment--card light-red" >
                    <div class="card--header">
                        <div class="amount">
                            <span class="title">
                                TOTAL MEMBER ADDED
                            </span>
                            <span class="amount-value"><h6>
                                <?php 
                                    $query = "SELECT * FROM studentorgtable where studentorgtable.org1 = $orgID";
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

                <div class="payment--card light-red" >
                    <div class="card--header">
                        <div class="amount">
                            <span class="title">
                                TOTAL ACTIVE MEMBER 
                            </span>
                            <span class="amount-value"><h6>
                                <?php 
                                    $query = "SELECT *
                                    FROM studenttable
                                    INNER JOIN studentorgtable ON studenttable.studentID = studentorgtable.studentID
                                    WHERE studentorgtable.org1 = '$orgID' AND studenttable.Status = 'Active'";
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

                <div class="payment--card light-red" >
                    <div class="card--header">
                        <div class="amount">
                            <span class="title">
                                TOTAL INACTIVE MEMBER 
                            </span>
                            <span class="amount-value"><h6>
                                <?php 
                                    $query = "SELECT *
                                    FROM studenttable
                                    INNER JOIN studentorgtable ON studenttable.studentID = studentorgtable.studentID
                                    WHERE studentorgtable.org1 = '$orgID' AND studenttable.Status = 'Inactive'";
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

              
                
<!-- /* CARD 2 */ -->
               
            </div>
        
    </div>       
    <?php 
        $sql2 = "SELECT * FROM eventtable WHERE eventtable.orgID = '0'";
        $result2 = $conn -> query($sql2);
        if ($result2->num_rows > 0) {
        while ($row2 = $result2->fetch_assoc()) {        
    ?>
    <div class="tabular--wrapper">
            <h3 class="main--tile">SSG ANNOUNCEMENTS</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                        <?php 
                                         echo "<h3>On Going Event: ".$row2["eventDescription"] ."</h3>".
                                        "Event Date: ".$row2["eventDate"]." Event Time: ".$row2["eventTime"]."AM"; 
                                ?>
                        </tr>
                        <tbody>
                            
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
        
 <?php 
} 
?>


<?php

}

 ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
                    // If user confirms, submit the form for logout
                    document.getElementById("logoutForm").submit();
                }
            });
            return false; // Prevent form submission
        }
    </script>
</body>

</html>