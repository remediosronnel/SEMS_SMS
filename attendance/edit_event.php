<?php
session_start();  
include "dbconnect.php";

$eventID = $_GET["eventID"];

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = new mysqli($sname, $uname, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}


$recepientType = "";
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
    $recepientType = $_POST['recepientType'];
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

        logActivity('0', $date, 'Update', 'User edited the event for '."$recepientType", $time);

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
    <form method = "POST">
      <div class="form-group">

      <label>Recipient Type</label>
        <select class="form-control" id="recepientType" name="recepientType" onchange="toggleRecepient()" value="<?php echo $recepientType ?>" >
        <option value="">TYPE OF RECIPIENT</option>  
        <option value="RSO">RSO</option>
        <option value="Student">Student</option>
        </select>

        <input  type="hidden" class="form-control" id="recePient" name="recePient" value = "<?php echo $recePient ?>">
           
        
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
        <input type="text" class="form-control" name="orgName" id="orgName" value="AsscatSSG" readonly required>
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