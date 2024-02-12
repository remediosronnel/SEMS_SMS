<?php
// Establish database connection
$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";
$counter = 0;

$conn = new mysqli($sname, $uname, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch attendance data based on the selected eventDescription
if(isset($_POST['eventDescription'])) {
    $eventDescription = $_POST['eventDescription'];
    $sql = "SELECT * FROM attentable WHERE eventDescription = '$eventDescription'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $counter++;
            echo "<tr>";
            echo "<td>".$counter."</td>";
            echo "<td>".$row['idNumber']."</td>";
            echo "<td>".$row['StudentName']."</td>";
            echo "<td>".$row['TimeIn']."</td>";
            echo "<td>".$row['TimeOut']."</td>";
            echo "<td>".$row['LogDate']."</td>";
            echo "<td>".$row['Status']."</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No attendance records found</td></tr>";
    }
}
$conn->close();
