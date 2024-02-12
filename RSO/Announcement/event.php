<?php session_start();  
include "dbconnect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);
$orgID = isset($_SESSION['orgID']) ? $_SESSION['orgID'] : '';
$eventID = "";

$number = "";

$conn = mysqli_connect("127.0.0.1", "root", "", "lazaca");

if (!$conn) {
	echo "Connection failed!";
}

$sql2 = "SELECT rsotable.orgID from rsotable";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();


$recepientType = "";
$recePient = "";
$orgName = "";
$eventDecription = "";
$eventDate = ""; 
$eventTime = "";  

if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $recepientType = "Student";
        $recePient = $_POST['recePient'];
        $orgName = $_POST['orgName'];
        $eventDecription = $_POST['eventDescription'];
        $eventDate = $_POST['eventDate'];
        $eventTime = $_POST['eventTime'];
      

        do{
          if(empty($recePient)||empty($orgName)||empty($eventDecription)||empty($eventDate)||empty($eventTime)){
              $errorMessage = "All the fields are required";
              break;
          }
        
          $sql5 = "INSERT INTO eventtable (orgID, recepientType, recePient, orgName, eventDescription, eventDate, eventTime)" . "VALUES ('$orgID', '$recepientType', '$recePient','$orgName', '$eventDecription', '$eventDate', '$eventTime')"; 
          $result5 = $conn ->query($sql5);
                 
          logActivity($orgID, $date, 'Send SMS', 'User sent message to Members '."$orgName"." ".$recepientType, $time);

          if(!$result5){
              $errorMessage = "Invalid query: " . $conn->error;
              break;
          }
        
          


          $recepientType = "";
          $recePient = "";
          $orgName = "";
          $eventDecription = "";
          $eventDate = "";  
          $eventTime = "";  
          
        
          $successMessage = "Client added correctly";
          header("Location:/SSG/RSO/home.php");
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
  <!-- <script type = "text/javascript" src= "fetchNO.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  
  
</head>
<body>
  <div class="container mt-5">
    <h2>Event Information</h2>
    <form method = "post">
      <div class="form-group">
        <label for="orgName">RECIPIENT RSO</label>
          <?php     
          $sql = "SELECT * FROM rsotable WHERE rsotable.orgID = '$orgID'";
          $result = $conn -> query($sql);
          $row = $result -> fetch_assoc();
          ?>

          <?php 
          if ($row && isset($row['orgName'])) {
            echo '<input type="text" class="form-control" readonly id="recePient" name="recePient" value="' . $row['orgName'] . ' Students">';
        } else {
            // Handle the case where $row['orgName'] doesn't exist or is null
            echo '<input type="text" class="form-control" readonly id="recePient" name="recePient" value="Default Value">';
        }
          ?>
                           
      </div>
      <div>
          <?php
            $sql6 = "SELECT contactNo FROM studentorgtable WHERE studentorgtable.org1 = '$orgID'";
            $result6 = mysqli_query($conn, $sql6);        
               
             if ($result6) {
              $modifiedNumbers = [];
                while($row6 = mysqli_fetch_assoc($result6)){
                  $contactNumber = $row6['contactNo'];

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
                  <?php if (isset($_POST['number'])) {
                      $number = isset($_POST['number']) ? $_POST['number'] : '';
                  }?>  
              </td>
          </tr>

        </tbody>
      </div>
      <div class="form-group">
        <label for="orgName">ORGANIZATION NAME</label>
                  <?php 
                     $sql = "SELECT * FROM rsotable WHERE rsotable.orgID = '$orgID'";
                     $result = $conn->query($sql);
                     $row = $result->fetch_assoc();
                  ?>

      <input type="text" readonly class="form-control" name="orgName" id="orgName" value="<?php echo$row['orgName'];?>" placeholder="Enter Organization Name" required>

      </div>
      <div class="form-group">
        <label for="eventDescription">EVENT DESCRIPTION</label>
        <textarea class="form-control" id="eventDescription" name="eventDescription" rows="3" placeholder="Enter Event Description" required></textarea>
      </div>
      <div class="form-group">
        <label for="eventDate">EVENT DATE</label>
        <input type="date" class="form-control" id="eventDate" name="eventDate" required>
      </div>
      <div class="form-group">
        <label for="eventTime">EVENT TIME</label>
        <input type="time" class="form-control" id="eventTime" name="eventTime" required>
      </div>
      <button type="submit" id="submit" name="submit" class="btn btn-primary">SEND</button>
      <button type="cancel" onclick="javascript:window.location='/SSG/RSO/home.php'" class="btn btn-primary">Cancel</button>
      
   
      

      </div> 
      <?php
       $sql3 = "SELECT * FROM eventtable WHERE eventtable.orgID = '$orgID'";
       $result3 = $conn->query($sql3);
       
       if ($result3 && $result3->num_rows > 0) {
           
           $row3 = $result3->fetch_assoc();
           
           if ($row && isset($row3['eventID'])) {
               
               $_SESSION['eventID'] = $row3['eventID'];
               $eventID = $row3['eventID'];

              
           } else {
              
               $_SESSION['eventID'] = null; 
           }
       } else {
           
           $_SESSION['eventID'] = null; 
       }
       
        ?>
    </form>
    <script>
        $(document).ready(function(){
            $("#submit").click(function(){
                var apiKey = 'b74f05f439f7746702f71cd8af31ac03';
                var number = $("#number").val().trim();
                var message = $("#eventDescription").val();
                var sendername = $("#orgName").val();

                $.ajax({
                    url: 'send_message.php', // Replace with the file handling the SMS sending logic
                    type: 'POST',
                    data: {
                        apiKey: apiKey,
                        number: number,
                        message: message,
                        sendername: sendername

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