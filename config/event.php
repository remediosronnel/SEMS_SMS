<?php
session_start();  
include("dbconnect.php");

$con = mysqli_connect("127.0.0.1", "root", "", "lazaca");
$conn = mysqli_connect("127.0.0.1", "root", "", "lazaca");
if (!$con) {
	echo "Connection failed!";
} else {
$sql2 = "SELECT ssgtable.orgID from ssgtable";
$result2 = $con->query($sql2);
$row2 = $result2->fetch_assoc();
$_SESSION['orgID'] = $row2['orgID'];
$orgID = $row2['orgID'];

}

$recepientType = "";
$recePient = "";
$orgName = "";
$eventDecription = "";
$eventDate = "";
$eventTime = "";    
?>

<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
      
        $recepientType = isset($_POST['recepientType']) ? $_POST['recepientType'] : "";
        $recePient = isset($_POST['recePient']) ? $_POST['recePient'] : "";
        $orgName = isset($_POST['orgName']) ? $_POST['orgName'] : "";
        $eventDecription = isset($_POST['eventDescription']) ? $_POST['eventDescription'] : "";
        $eventDate = isset($_POST['eventDate']) ? $_POST['eventDate'] : "";
        $eventTime = isset($_POST['eventTime']) ? $_POST['eventTime'] : "";
        
        



        do{
          if(empty($recepientType)||empty($recePient)||empty($orgName)||empty($eventDecription)||empty($eventDate)||empty($eventTime)){
              $errorMessage = "All the fields are required";
              break;
          }
        
          $sql1 = "INSERT INTO eventtable (orgID, recepientType, recePient, orgName, eventDescription, eventDate, eventTime)" .
          "VALUES ('$orgID','$recepientType','$recePient','$orgName', '$eventDecription', '$eventDate', '$eventTime')"; 
        
          $result1 = $conn ->query($sql1);

          logActivity($orgID, $date, 'Sending SMS', 'User sent messages to'."$recepientType", $time);
        
        
          if(!$result1){
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
          
          header("location: /SSG/home.php");
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
  
   <script>
    function toggleRecepient() {
      var recepientType = document.getElementById('recepientType').value;
      if (recepientType === 'RSO') {
        document.getElementById('rsoFields').style.display = 'block';
        document.getElementById('studentFields').style.display = 'none';
      } else if (recepientType === 'Student') {
        document.getElementById('rsoFields').style.display = 'none';
        document.getElementById('studentFields').style.display = 'block';
        fetchStudentNumbers(); 
      }
    }

    function fetchStudentNumbers() {
      function fetchStudentNumbers() {
      var xhttp = new XMLHttpRequest();
  
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      // Handle the response from the server here
      var response = this.responseText;
      document.getElementById('ans').innerHTML = response; 
    }
  };
  
  xhttp.open("GET", "fetch_student_numbers.php", true); 
  xhttp.send();
}
      document.getElementById('ans').innerHTML = '<tr><td>Student 1: 123456789</td></tr><tr><td>Student 2: 987654321</td></tr>';
    }
  </script>
  
</head>
<body>
  <div class="container mt-5">
    <h2>Event Information</h2>
    <form method = "post">
      <div class="form-group">

      <label>Recipient Type</label>
        <select class="form-control" id="recepientType" name="recepientType" onchange="toggleRecepient()">
        <option value="">TYPE OF RECIPIENT</option>  
        <option value="RSO">RSO</option>
        <option value="Student">Student</option>
        </select>

        
        <input  type="hidden" class="form-control" id="recePient" name="recePient" value = "<?php $sql3 = "SELECT Distinct * from rsotable";
                                      $result3 = $con->query($sql3);
                                      while($row = $result3->fetch_assoc()){
                                        echo $row['orgName'].",";
                                      }
                                ?>">
            
           
        
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
              
                  $modifiedNumber = '+63' . substr($contactNumber, 1);
                  $modifiedNumbers[] = $modifiedNumber; 
              } else {
                  $modifiedNumbers[] = $contactNumber; 
                }
                  
              }
    
              if (!empty($modifiedNumbers)) {
                echo '<input type="hidden" id="number" name="number" value="' . implode(',', $modifiedNumbers) . '" />';
            } else {
                // Handle the case where $modifiedNumbers is empty
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
        <input type="text" class="form-control" name="orgName" id="orgName" value="AsscatSSG" readonly required>
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
      <button type="submit" name="submit" id="submit" class="btn btn-primary">SEND</button>
      <button type="cancel" onclick="javascript:window.location='/SSG/home.php'" class="btn btn-primary">Cancel</button>

      


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