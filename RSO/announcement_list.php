<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RSO LIST</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">"
    
</head>
<body>
    <a id="save_to_image"> 
    <div class="invoice-container">
        <div class="container my-5"> 
        <div class="logo" src="ssg.png"> 
            <img src="ssg.png" 
            style="width: 100px; height:100px"
            />
        </div>
    <table  cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                    <th>Event ID</th>
                    <th>Recipient</th>
                    <th>Organization Name </th>
                    <th>Event Description</th>
                    <th>Event Date</th>
                    <th>Ent</th>
                      
            </tr>
        </thead>

            <?php
            session_start();
            include "db_conn.php";
            
            $orgID = $_SESSION['orgID'];
            $sname = "127.0.0.1";
            $uname = "root";
            $password = "";
            $db_name = "lazaca";

            $conn = new mysqli($sname, $uname, $password, $db_name);

            if (!$conn) {
                echo "Connection failed!";
            }
            $sql = "SELECT * FROM eventtable  WHERE orgID ='$orgID'";
            $result = $conn->query($sql);
            logActivity($orgID, $date, 'Generate', 'User generated List of Events', $time);
            if(!$result){
                die("Invalid query: " .$conn->error);
            }
            while($row = $result->fetch_assoc()){
                echo "
                    <tr>
                    <td>$row[eventID]</td>
                    <td>$row[recePient]</td>
                    <td>$row[orgName]</td>
                    <td>$row[eventDescription]</td>
                    <td>$row[eventDate]</td>
                    </tr> 
                    ";
            }
            ?>
    </tbody>

    </table>


    </a>
        
    
    </div>           
</div>
</div>
    <div class = "buttons-container">
        
        <button id="print">Print</button>
        <button id="cancel">Cancel</button>
    </div>
        <script src="html2canvas.js"></script>
        <script src="rso_list.js"></script>
   
</body>

</html>