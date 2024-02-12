<?php 
session_start();
$i = 0;
include "db_conn.php";

if (isset($_GET['eventID']) && isset($_GET['orgID'])) {
    $_SESSION['eventID'] = $_GET['eventID'];
    $_SESSION['orgID'] = $_GET['orgID'];
}

$eventID = $_SESSION['eventID'] ?? null;
$orgID = $_SESSION['orgID'] ?? null;
$orgID1 = "";


$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = new mysqli($sname, $uname, $password, $db_name);



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/8.2.3/adapter.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.4.13/vue.cjs.min.js"></script>
  <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <meta charset="UTF-8">
  <title>Student Attendance</title>
  <style>
      table{
        text-align:center;
        width: 50%;
      }
      th {
        height: 70px;
      }

  </style>
  

</head>
<body>
  <div class="container">
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand">RSO ATTENDANCE</a>
    </div>
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="/SSG/RSO/attendance/show_attendance.php">BACK</a>
      
    </div>

  </nav>

    <div class="row">
      <div class="col-md-6">
          <video id="preview" width="100%"></video>
         

      </div>
      <div class="col-md-6">
        <form action="" method="post" class="form-horizontal">
        <div id="digital-clock"></div> 
          <label>SCAN QR CODE</label>
          <input type="hidden" name="text" id="text" readonly="" placeholder="scan qrcode" class="form-control">
        </form>
       

        <table class="table table-bordered">
          <thead>
            <tr>
              <td  width="10%">ATTENDANCE ID</td>
              <td>STUDENT NAME</td>
              <td>TIME IN</td>
              <td>TIME OUT</td>
              <td>LOG DATE</td>
              <td>STATUS</td>
            </tr>
          </thead>
          <tbody>
            <?php
          
              $conn = new mysqli("127.0.0.1", "root", "", "lazaca");

              if($conn->connect_error){
                die("Connection failed". $conn->connect_error);
              }

              $sql = "SELECT * FROM rso_attentable WHERE rso_attentable.orgID = '$orgID' and rso_attentable.eventID = '$eventID'";
              $query = $conn->query($sql);
              
              while($row = $query->fetch_assoc()){ 
                $i++;
                ?>
                </form>
                  <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $row['StudentName']; ?></td>
                    <td><?php echo $row['TimeIn']; ?></td>
                    <td><?php echo $row['TimeOut']; ?></td>
                    <td><?php echo $row['LogDate']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                  </tr>

                <?php  
              } 
            ?>
          </tbody>

        </table>
      </div>
    </div>
    <br>
    <button type="submit" class="btn btn-success pull-right" onclick="Export()">
              <i class="fa fa-file-excel-o fa-fw"></i> EXPORT EXCEL
    </button>
  </div>
<?php 

if(isset($_POST['text']) ){
           
  try{
  $text = trim($_POST['text']); 
  date_default_timezone_set('Asia/Manila');
  $date = date('m-d-Y');
  $curDate = date('m-d-Y', strtotime("+1 day"));
  $time = date('h:i:s');


  $sql = "SELECT * FROM studentorgtable WHERE studentorgtable.idNumber = '$text' and studentorgtable.org1 = '$orgID'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $studentID = $row['studentID'];
  $idNumber = $row['idNumber'];
  
  $voice = new COM("SAPI.SpVoice");
  
  
  if($idNumber != $text){
   $message1 = "Unaccepted Data!!!";  
   $voice ->speak($message1);
   header("Location: attendance.php"); 

  }else{
 
   $text1 = $text;

  $studentName = $row['firstName'].' '.$row['middleName'].' '.$row['lastName'];

  logActivity($orgID, $date, 'Attendance', 'User are scanning for  the Attendance', $time);
 
  $message = "Hi".$studentName."Your attendance has been successfully added! Thank you!";

  $sql5 = "SELECT * FROM eventtable where eventID = '$eventID'";
  if (!empty($sql5)) {
   $result5 = $conn->query($sql5);
   $row5 = mysqli_fetch_assoc($result5);
   $eventDescription = $row5["eventDescription"];

  }else{
   header("Location: show_attendance.php"); 
  }
           
 
  $sql1="SELECT COUNT(idNumber) AS count FROM rso_attentable WHERE rso_attentable.idNumber = '$text1' AND rso_attentable.eventID = '$eventID'";
  $query1 = $conn->query($sql1);
  $row = mysqli_fetch_assoc($query1);


  $sql = "SELECT * FROM rso_attentable WHERE rso_attentable.idNumber = '$text1' AND rso_attentable.LogDate = '$date' AND rso_attentable.Status = '0'";
  $query = $conn->query($sql);
  $row1 = mysqli_fetch_assoc($query1);
  
  if(($row['count'] <= 1) && ($date < $curDate)){

      if(($query->num_rows > 0) AND (($row['count'] == 1))){

          $sql = "UPDATE rso_attentable SET TimeOut = '$time', Status = '1' WHERE studentID = '$studentID' AND LogDate = '$date' AND eventID = '$eventID'";
          $query = $conn -> query($sql);
          $voice -> speak($message);
          $_SESSION['succes'] = 'Successfully time in';   
         header('Location: attendance.php');
          
      }else if ($row['count'] == 0){
    
              $sql = "INSERT INTO rso_attentable(studentID, idNumber, StudentName, TimeIn, LogDate, Status, orgID, eventID, eventDescription) VALUES('$studentID', '$text1', '$studentName', '$time', '$date', '0', '$orgID', '$eventID','$eventDescription')";
              if($conn -> query($sql) === true){
                  $_SESSION['success'] = 'Successfully Time In';
                  $voice ->speak($message);
                  header('Location: attendance.php');
              }else{
                  $_SESSION['error'] = $conn->error;
                  $voice ->speak($message1);
              }
              header('Location: attendance.php');
          
      }else{
         $voice = new COM("SAPI.SpVoice");
         $message1 = "Unaccepted Data!!!";  
         $voice ->speak($message1);
         header("Location: attendance.php"); 
       
      }
      
  }else{
      $voice = new COM("SAPI.SpVoice");
      $message1 = "Unaccepted Data!!!";  
      $voice ->speak($message1);
      header("Location: show_attendance.php"); 
   
  }
 }

 }catch(ErrorException $e){
   $voice = new COM("SAPI.SpVoice");
   $message1 = "Unaccepted Data!!!";
   $voice ->speak($message1);
   
}
  
  }


$conn-> close();    
       ?>



 <script>
      function Export(){
        var conf = confirm("Please confirm if you wish to proceed in exporting the attendance to Excel File");
        if(conf == true){
          window.open("export.php",'_blank');
        }
      }

  </script>

  <script>
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), facingMode: "environment"});
      Instascan.Camera.getCameras().then(function(cameras){
        if(cameras.length > 0){
          scanner.start(cameras[0]);
        }else{
          alert('No cameras found');
        }
      }).catch(function(e){
        console.error(e); 
      });
      scanner.addListener('scan', function(c){
        document.getElementById('text').value=c;
        document.forms[0].submit();
      });


  </script>
  <script type="text/javascript">
    var timestamp = '<?=time();?>';
    function updateTime(){
      $('#time').html(Date(timestamp));
      timestamp++;
    }
    $(function(){
        setInterval(updateTime, 1000)
   
  </script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
 
    <script>
      $("example1").DataTable({
        "responsive": true,
        "autoWidth": false,
      });
      $('#example2').DataTable({
        "paging":true,
        "lengthChange": false,
        "searching":false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });

    </script>
 <script>
        function showError(errorMessage) {
            alert(errorMessage); 
        }
    </script>
    <script>
    document.getElementById("eventForm").value;
    </script>
    <script>
        function updateClock() {
            var now = new Date();

            // Set default time (adjust as needed)
            var defaultHours = 9;
            var defaultMinutes = 0;
            var defaultSeconds = 0;

            // Set the current time to default if it's before the default time
            if (now.getHours() < defaultHours ||
                (now.getHours() == defaultHours && now.getMinutes() < defaultMinutes)) {
                now.setHours(defaultHours, defaultMinutes, defaultSeconds);
            }

            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();

            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            var timeString = hours + ':' + minutes + ':' + seconds;

            document.getElementById('digital-clock').innerHTML = timeString;
        }

        // Update the clock every second
        setInterval(updateClock, 1000);

        // Initial call to display clock immediately
        updateClock();
    </script>

</body>
</html>
