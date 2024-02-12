<?php
session_start();  
include "db_conn.php";

$eventID = $_GET["eventID"];
$orgID = $_SESSION['orgID'];

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = new mysqli($sname, $uname, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}


$recepientType = "Student";
$recePient = "";
$orgName = "";
$eventDescription = "";
$eventDate = "";  
$eventTime = "";

$errorMessage = "";
$successMessage = "";


if($_SERVER['REQUEST_METHOD'] == 'GET'){

    if(!isset($_GET["eventID"])){
        header("location: show_attendance.php");
        exit;
    }

   

    $sql = "SELECT * FROM eventtable WHERE eventtable.eventID = $eventID";
    $result = $conn ->query($sql);
    $row = $result->fetch_assoc();
    
 
    if(!$row){
        header("location: student.php");
        exit;
    }
    $recepientType = $row['recepientType'];
    $recePient =  $row['recePient'];
    $orgName =  $row['orgName'];
    $eventDescription =  $row['eventDescription'];
    $eventDate =  $row['eventDate'];  
    $eventTime =  $row['eventTime'];

        

}
else{
    $recepientType = "Student";
    $recePient =  $_POST['recePient'];
    $orgName =  $_POST['orgName'];
    $eventDescription =  $_POST['eventDescription'];
    $eventDate =  $_POST['eventDate'];  
    $eventTime =  $_POST['eventTime'];
       

        do{
            if(empty($recepientType)||empty($recePient)||empty($orgName)||empty($eventDescription)||empty($eventDate)||empty($eventTime)){
                $errorMessage = "All the fields are required";
                break;
        }

        $sql = "UPDATE eventtable " .
            "SET recepientType = '$recepientType', recePient = '$recePient', orgName = '$orgName', eventDescription = '$eventDescription', eventDate = '$eventDate', eventTime = '$eventTime'" .
            "WHERE eventID = '$eventID'";

        $result = $conn->query($sql);
        logActivity($orgID, $date, 'Update', 'User updated the event of '." $orgName", $time);

        if(!$result){
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }

        $successMessage = "Event Updated Correctly!";

        header("location: show_attendance.php");
        exit;

    }while (true);
}


?>

    
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Form</title>
  <!-- <script type = "text/javascript" src= "fetchNO.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  
  
</head>
<body>
  <div class="container mt-5">
    <h2>Event Information</h2>
    <form method = "POST">
      <div class="form-group">

      <label>Recipient</label>
      <?php     
          $sql = "SELECT * FROM rsotable WHERE rsotable.orgID = '$orgID'";
          $result = $conn -> query($sql);
          $row = $result -> fetch_assoc();
          ?>

          <?php 
          if ($row && isset($row['orgName'])) {
            echo '<input type="text" class="form-control" readonly id="recePient" name="recePient" value="' . $row['orgName'] . ' Members">';
        } else {
     
            echo '<input type="text" class="form-control" readonly id="recePient" name="recePient" value="Default Value">';
        }
          ?>
      </div>
      <div id="rsoFields">
      <?php    
      $sql7 = "SELECT * FROM rsotable";
      $result7 = $conn->query($sql7);

      if ($result7) {
        $modifiedNumbers = [];
          while($row7 = mysqli_fetch_assoc($result7)){
            $contactNumber = $row7['contactNo'];

            if (substr($contactNumber, 0, 1) === '0') {
          
              $modifiedNumber = '+63' . substr($contactNumber, 1);
              $modifiedNumbers[] = $modifiedNumber; 
          } else {
              $modifiedNumbers[] = $contactNumber; 
            }
              
          }

          if (!empty($modifiedNumbers)) {
            echo '<input type="hidden" id="number" name="number" value="' . implode(',', $modifiedNumbers) . '" />';
        } else {
            
            echo '<input type="hidden" id="number" name="number" value="Default Value" />';
        }
        } else {
            echo "Error fetching contacts: " . mysqli_error($conn);
        }
    ?>
      </div>

      <div id="studentFields" style="display: none;">
      <?php 
       $sql8 = "SELECT * FROM studenttable";
       $result8 = $conn->query($sql8); 
      ?>
        <div class="ans">
          <?php 
           if ($result8) {
            $modifiedNumbers = [];
              while($row8 = mysqli_fetch_assoc($result8)){
                $contactNumber = $row8['contactNo'];
    
                if (substr($contactNumber, 0, 1) === '0') {
              
                  $modifiedNumber = '+63'.substr($contactNumber, 1);
                  $modifiedNumbers[] = $modifiedNumber; 
              } else {
                  $modifiedNumbers[] = $contactNumber; 
                }
                  
              }
    
              if (!empty($modifiedNumbers)) {
                echo '<input type="hidden" id="number" name="number" value="' . implode(',', $modifiedNumbers) . '" />';
            } else {
              
                echo '<input type="hidden" id="number" name="number" value="Default Value" />';
            }
            } else {
                echo "Error fetching contacts: " . mysqli_error($conn);
            }
          ?>
          
          
        </div>
      </div>
      <div class="form-group">
        <label for="orgName">ORGANIZATION NAME</label>
        <input type="text" class="form-control" name="orgName" id="orgName" value="<?php echo $row['orgName'] ?>" readonly required>
      </div>
      <div class="form-group">
        <label for="eventDescription">EVENT DESCRIPTION</label>
        <textarea class="form-control" id="eventDescription" name="eventDescription" rows="3" > <?php echo htmlspecialchars($eventDescription) ?> </textarea>
      </div>
      <div class="form-group">
        <label for="eventDate">EVENT DATE</label>
        <input type="date" class="form-control" id="eventDate" name="eventDate"  value="<?php echo $eventDate ?>" required>
      </div>
      <div class="form-group">
        <label for="eventTime">EVENT TIME</label>
        <input type="time" class="form-control" id="eventTime" name="eventTime" value = "<?php echo $eventTime ?>" required>
      </div>

      <button type="submit" class="btn btn-primary">SEND</button>
      <a class="btn btn-outline-primary" href="show_attendance.php" role="button">Cancel</a>
     
      </div> 
    </form>
    <script>
        $(document).ready(function(){
            $("#submit").click(function(){
                var apiKey = 'b74f05f439f7746702f71cd8af31ac03';
                var number = $("#number").val().trim();
                var message = $("#eventDescription").val();
                var sendername= $("#orgName").val();

                $.ajax({
                    url: 'send_message.php', // Replace with the file handling the SMS sending logic
                    type: 'POST',
                    data: {
                        apiKey: apiKey,
                        number: number,
                        message: message,
                        sendername:sendername

                    },
                    success: function(response) {
                        alert(response); // Display success or failure message
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + error); // Display error if AJAX request fails
                    }
                });
            });
        });
    </script>
  </body>
</html>