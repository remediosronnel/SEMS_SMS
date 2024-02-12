<?php
session_start();  

$orgID = isset($_SESSION['orgID']) ? $_SESSION['orgID'] : '';
$eventID = isset($_SESSION['eventID']) ? $_SESSION['eventID'] : null;

$number = "";
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
        
          $sql5 = "INSERT INTO eventtable (orgID, recePient, orgName, eventDescription, eventDate)" . "VALUES ('$orgID','$recePient','$orgName', '$eventDecription', '$eventDate')"; 
        
          $result5 = $conn ->query($sql5);
                 
        
          if(!$result5){
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
  <!-- <script type = "text/javascript" src= "fetchNO.js"></script> -->
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
    <form method = "post" id='messageForm'>
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
            <td><?php
            $sql6 = "SELECT contactNo FROM studenttable WHERE studenttable.orgID = '$orgID'";
            $result6 = mysqli_query($con, $sql6);        
            $row6 = mysqli_fetch_assoc($result6);    
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

                echo '<input type="text" id="number" name="number" value="' . implode(',', $modifiedNumbers) . '" />';
              } else {
                  echo "Error fetching contacts: " . mysqli_error($con);
              }
              mysqli_close($con);?> 
                  <?php    if (isset($_POST['number'])) {
                      $number = isset($_POST['number']) ? $_POST['number'] : '';
                  }?>  
              </td>
          </tr>

        </tbody>
      </div>
      <div class="form-group">
        <label for="orgName">ORGANIZATION NAME</label>
        <input type="text" class="form-control" name="orgName" id="orgName" value="<?php 
         $sql = "SELECT * FROM rsotable WHERE rsotable.orgID = '$orgID'";
         $result = $conn -> query($sql);
         $row = $result -> fetch_assoc();
        echo $row['orgName'];?>" placeholder="Enter Organization Name" required>
      </div>
      <div class="form-group">
        <label for="eventDescription">EVENT DESCRIPTION</label>
        <textarea class="form-control" id="eventDescription" name="eventDescription" rows="3" placeholder="Enter Event Description" required></textarea>
      </div>
      <div class="form-group">
        <label for="eventDate">EVENT DATE</label>
        <input type="date" class="form-control" id="eventDate" name="eventDate" required>
      </div>
      <button type="button" id="submit" name="submit" class="btn btn-primary">SEND</button>
      <button type="cancel" onclick="javascript:window.location='/SSG/RSO/home.php'" class="btn btn-primary">Cancel</button>
      
   
      

      </div> 
      <?php
       $sql3 = "SELECT * FROM eventtable WHERE eventtable.orgID = '$orgID'";
       $result3 = $conn->query($sql3);
       
       if ($result3 && $result3->num_rows > 0) {
           
           $row = $result3->fetch_assoc();
           
           if ($row && isset($row['eventID'])) {
               
               $_SESSION['eventID'] = $row['eventID'];
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
                var number = $("#number").val();
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