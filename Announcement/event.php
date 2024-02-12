<?php
session_start();  
include("dbconnect.php");
$orgID = $_SESSION['orgID'];

$con = mysqli_connect("127.0.0.1", "root", "", "lazaca");
$conn = mysqli_connect("127.0.0.1", "root", "", "lazaca");
if (!$con) {
	echo "Connection failed!";
} else {

$sql2 = "SELECT rsotable.orgID from rsotable";
$result2 = $con->query($sql2);
$row2 = $result2->fetch_assoc();

"<break>";
}

$recePient = "";
$orgName = "";
$eventDecription = "";
$eventDate = "";  
?>

<?php 


             
            	

if($_SERVER['REQUEST_METHOD'] == 'POST'){
        

        $recePient = $_POST['recePient'];
        $orgName = $_POST['orgName'];
        $eventDecription = $_POST['eventDescription'];
        $eventDate = $_POST['eventDate'];
        



        do{
          if(empty($recePient)||empty($orgName)||empty($eventDecription)||empty($eventDate)){
              $errorMessage = "All the fields are required";
              break;
          }
        
          $sql1 = "INSERT INTO eventtable (orgID, recePient, orgName, eventDescription, eventDate  )" .
          "VALUES ('$orgID','$recePient','$orgName', '$eventDecription', '$eventDate')"; 
        
          $result1 = $conn ->query($sql1);
        
        
          if(!$result1){
              $errorMessage = "Invalid query: " . $conn->error;
              break;
          }
        
          
          $recePient = "";
          $orgName = "";
          $eventDecription = "";
          $eventDate = "";  
          
        
          $successMessage = "Client added correctly";
          
          header("location: /SSG/RSO/home.php");
          exit;
        
        
        }while(false);

      }



      ?>
    
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Form</title>
  <script type = "text/javascript" src= "fetchNO.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style type="text/css">
      table{
        border: 1px solid;
      }
      th,td,tr{
        border: 1px solid;
      }

  </style>
  
</head>
<body>
  <div class="container mt-5">
    <h2>Event Information</h2>
    <form method = "POST">
      <div class="form-group">
        <label >RECIPIENT RSO</label>
          <?php     
          $sql = "SELECT * FROM rsotable WHERE rsotable.orgID = '$orgID'";
          $result = $conn -> query($sql);
          $row = $result -> fetch_assoc()
          
          ?>
        <input type="text"  class="form-control" id="recePient" name="recePient" value="<?php echo $row['orgName'] ." ". "Students"?>">
                        
      </div>
      <div class="ans">
        <thead>
          <th style="width: 70%"> NUMBER </th>
        </thead>
        <tbody id="ans">
          <tr>
            <td> <?php
            $sql1 = "SELECT orgID, contactNo FROM studenttable WHERE studenttable.orgID = '$orgID'";
            $result1 = $conn -> query($sql1);
                while($rows = mysqli_fetch_assoc($result1)){
                  echo $rows['contactNo'];
                }
            
            ?></td>
          </tr>

        </tbody>
      </div>
      <div class="form-group">
        <label for="orgName">ORGANIZATION NAME</label>
        <input type="text" class="form-control" name="orgName" id="orgName" value="<?php echo $row['orgName'] ?>" placeholder="Enter Organization Name" required>
      </div>
      <div class="form-group">
        <label for="eventDescription">EVENT DESCRIPTION</label>
        <textarea class="form-control" id="eventDescription" name="eventDescription" rows="3" placeholder="Enter Event Description" required></textarea>
      </div>
      <div class="form-group">
        <label for="eventDate">EVENT DATE</label>
        <input type="date" class="form-control" id="eventDate" name="eventDate" required>
      </div>
      <button type="submit" class="btn btn-primary">SEND</button>
      <button type="cancel" onclick="javascript:window.location='/SSG/RSO/home.php'" class="btn btn-primary">Cancel</button>

      


      </div> 
    </form>
  </body>
</html>