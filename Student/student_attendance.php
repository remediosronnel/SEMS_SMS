<?php
session_start();
$id = $_SESSION['studentID'];
$eventID = $_SESSION['eventID'];
$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

$i = 0;

$sql = "SELECT a.*, e.* FROM rso_attentable a
        LEFT JOIN eventtable e ON a.eventID = e.eventID
        WHERE a.studentID = '$id'";

$sql1 = "SELECT a.*, e.* FROM attentable a
        LEFT JOIN eventtable e ON a.eventID = e.eventID
        WHERE a.studentID = '$id'";

$query = $conn->query($sql);
$query1 = $conn->query($sql1);


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
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
        <a class="navbar-brand">STUDENT ATTENDANCE</a> 
      </div>
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="home.php">BACK</a> 
    </div>
  </nav>
<table class="table table-bordered">
          <thead>
            <tr>
              <td  width="10%">ATTENDANCE ID</td>
              <td width="15%">STUDENT NAME</td>
              <td width="10%">TIME IN</td>
              <td width="10%">TIME OUT</td>
              <td width="10%">LOG DATE</td>
              <td width="20%">EVENT NAME</td>
              <td width="10%">FEEDBACK</td>
            </tr>
          </thead>
          <tbody>
<?php
while ($row = mysqli_fetch_array($query)) {
    $i++;
    echo "
        <tr>
        <td>{$i}</td>
        <td>{$row['StudentName']}</td>
        <td>{$row['TimeIn']}</td>
        <td>{$row['TimeOut']}</td>
        <td>{$row['LogDate']}</td>
        <td>{$row['eventDescription']}</td>
        <td>";

    if (!($row['satRate'])  && !($row['sugComment'])) {
        echo "<a class='btn btn-primary btn-lg active' role='button' href='feedback.php?eventID={$row['eventID']}&studentID=$id'>OPEN</a>";
    } else {
        echo "<a type='button' class='btn btn-primary btn-lg disabled' role='button'>CLOSED</a>";
    }

    echo "</td></tr>";
}

while ($row1 = mysqli_fetch_array($query1)) {
  $i++;
  echo "
      <tr>
      <td>{$i}</td>
      <td>{$row1['StudentName']}</td>
      <td>{$row1['TimeIn']}</td>
      <td>{$row1['TimeOut']}</td>
      <td>{$row1['LogDate']}</td>
      <td>{$row1['eventDescription']}</td>
      <td>";

  if (!($row1['satRate'])  && !($row1['sugComment'])) {
      echo "<a class='btn btn-primary btn-lg active' role='button' href='ssg_feedback.php?eventID={$row1['eventID']}&studentID=$id'>OPEN</a>";
  } else {
      echo "<a type='button' class='btn btn-primary btn-lg disabled' role='button'>CLOSED</a>";
  }

  echo "</td></tr>";
}
?>
</tbody>
</table>
</div>
</body>
</html>
