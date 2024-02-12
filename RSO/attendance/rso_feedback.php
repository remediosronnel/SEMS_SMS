<?php 
session_start();
include "db_conn.php";
$orgID = $_SESSION['orgID'];

$host = "127.0.0.1";
$dbname = "lazaca";
$username = "root";
$password = "";


$conn = new mysqli("127.0.0.1", "root", "", "lazaca");
logActivity($orgID, $date, 'Feedback', 'User checked the feedbacks', $time);

try {
    // Establish a database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Specify the table and columns you want to sum
    $tableName = "rso_attentable";
    $numericColumns = ["satRate"]; // Replace with your column names

    // Build the SQL query dynamically
    $columnsString = implode(", ", $numericColumns);
    $sql = "SELECT SUM($columnsString) as total FROM $tableName where orgID = '$orgID'";

    $sql1 = "SELECT COUNT($columnsString) as numberrows FROM $tableName where orgID = '$orgID'";

    // Execute the query
    $result = $pdo->query($sql);
    $result1 = $pdo->query($sql1);
    
    if ($result) {
        // Fetch the result
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $row1 = $result1->fetch(PDO::FETCH_ASSOC);
        
        // Access the sum value
        $totalSum = $row['total'];
        $divisor = $row1['numberrows'];

        // Output the result
       
    } else {
        echo "Error executing the query.";
    }
    $quotient = $totalSum / $divisor;
    $numberForm = number_format($quotient, 2);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RSO Event</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
       
        td, th{
            text-align: center;
        }
        .btn{
           margin-left: 1000px;
        }
        @media print{
                body * {
                    visibility: hidden;
                }
                .print-container, .print-container * {
                    visibility: visible;
                }
        }

    </style>
</head>
<body>
<main class="table" id="table">
        <section class="print-container">
            <h1>EVENT FEEBACK</h1>
            <div class="export__file">
                
            </div>
        </section>
        <section class="table__body">
            <table class="print-container">
                <thead>
                    <tr>
                        <th width="5%"> Event ID </th>
                        <th width="15%">Event Name</th>
                        <th width="15%"> Rate </th>
                        <th width="30%"> Comment </th>
                       
                    </tr>
                </thead>

                <tbody>
                   
                    <tr>
                        <?php      

                        if (isset($_GET["eventID"]) && $_GET["eventID"] && isset($_GET["orgID"]) && $_GET["orgID"]){
                            $orgID = $_GET['orgID'];
                            $eventID = $_GET['eventID'];
                        
                            $sql = "SELECT * FROM rso_attentable WHERE rso_attentable.orgID = '$orgID' and rso_attentable.eventID = '$eventID'";
                            $result = $conn->query($sql);
                        
                        
                            while($row = $result->fetch_assoc()){
                                
                            echo "
                                    <tr>
                                    <td>$row[eventID]</td>
                                    <td>$row[eventDescription]</td>
                                    <td>$row[satRate]</td>
                                    <td>$row[sugComment]</td>
                                    </tr> 
                                    <tr> <td> Satisfaction Average: $numberForm </td></tr>
                                    ";
                    
                         }}    ?>
                    <tr><a href="/SSG/rso/attendance/show_attendance.php" class="fcc-btn"> BACK </a></tr>
                </tbody>
            </table>
         
        </section>
         <button onclick="window.print()" id="button" class="btn btn-primary">PRINT</button>
    </main>
   
</body>
</html>
