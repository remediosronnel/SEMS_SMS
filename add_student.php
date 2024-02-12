<?php
session_start();
include "db_conn.php";

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = new mysqli($sname, $uname, $password, $db_name);

if (!$conn) {
    echo "Connection failed!";
}

$orgID = '';
$eventID = "";

$idNumber = "";
$firstName = "";
$middleName = "";
$lastName = "";
$courseS = "";
$yearLevel = "";
$contactNo = "";
$status = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idNumber = $_POST["idNumber"];
    $firstName = $_POST["firstName"];
    $middleName = $_POST["middleName"];
    $lastName = $_POST["lastName"];
    $courseS = $_POST["courseS"];
    $yearLevel = $_POST["yearLevel"];
    $contactNo = $_POST["contactNo"];
    $status = 'Inactive';
    $orgID = 0;

    if (empty($idNumber) || empty($firstName) || empty($lastName) || empty($courseS) || empty($yearLevel) || empty($contactNo)) {
        $errorMessage = "All the fields are required";
    } else {
        // Check if the idNumber already exists in the studenttable
        $checkDuplicateQuery = "SELECT COUNT(*) AS count FROM studenttable WHERE idNumber = ?";
        $checkDuplicateStmt = $conn->prepare($checkDuplicateQuery);
        $checkDuplicateStmt->bind_param("s", $idNumber);
        $checkDuplicateStmt->execute();
        $result = $checkDuplicateStmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];

        $checkDuplicateStmt->close();

        if ($count > 0) {
            $errorMessage = "Error: ID Number already exists.";
        } else {
            // Proceed with the insertion
            $sql = "INSERT INTO studenttable (orgID, idNumber, firstName, middleName, lastName, courseS, yearLevel, contactNo, Status) " .
                "VALUES (?,?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issssssss", $orgID, $idNumber, $firstName, $middleName, $lastName, $courseS, $yearLevel, $contactNo, $status);

            logActivity('0', $date, 'Create', 'User added Student '."$firstName $middleName $lastName", $time);
            if ($stmt->execute()) {
                $successMessage = "Client added correctly";
                header("location: student.php");
                exit;
            } else {
                $errorMessage = "Error: " . $conn->error;
            }

            $stmt->close();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDENT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <style> 
             .class{
                width: 100px;
             } 
             .txt{
                width: 300px;
                height: 40px;
                text-align: center;
                margin-bottom: 20px;
             }
            

    </style>

</head>
<body>
    <div class="container my-5">
        <h2>NEW STUDENT</h2>
        <?php
        if(!empty($errorMessage)){
            echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$errorMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
            ";
        }
        ?>

        <form method="post" onsubmit="delayedRedirect(event)">
                


            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">ID Number</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="idNumber" value="<?php echo $idNumber;?>">
                </div>   
            </div>
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">FIRST NAME</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="firstName" value="<?php echo $firstName;?>">
                </div>   
            </div>
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">MIDDLE NAME</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="middleName" value="<?php echo $middleName;?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">LAST NAME</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="lastName" value="<?php echo $lastName;?>">
                </div>
            </div>
            <div class="row " style="max-width: 400px; padding-bottom: 20px; margin-left: 10px;">                       
            <label for="college">COLLEGE</label>
                <select name="college" id="college" onchange="getCollege(this.value)">
                    <option value="">Select College</option>
                    <option value="CA">CA</option>
                    <option value="CAS">CAS</option>
                    <option value="CEIT">CEIT</option>
                    <option value="CCIS">CCIS</option>
                    <option value="CTE">CTE</option>
                    <option value="GRAD">GRAD SCH</option>
                </select>
                <br>

                <label for="courseS">COURSE</label>
                <select required name="courseS" id="courseS">
                    <option value="">Select Course</option>
                  
                </select>
                <br>
            </div>                   

            
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">YEAR LEVEL</label>
                <div class="col-sm-6">
                    <select id="yearLevel" class="form-control" name="yearLevel" value="<?php echo $yearLevel;?>">
                        <option value="1st Year"> 1st Year </option>
                        <option value="2nd Year"> 2nd Year </option>
                        <option value="3rd Year"> 3rd Year </option>
                        <option value="4th Year"> 4th Year </option>
                        <option value="5th Year"> 5th Year </option>
                    </select>
               
                </div>
            </div>
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">CONTACT</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contactNo" value="<?php echo $contactNo;?>">
                </div>
            </div>
                    
            <?php

                if(!empty($successMessage)){
                    echo "
                    <div class='row mb-3'>
                        <div class='offset-sm-3 col-sm-6'>
                            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>$successMessage</strong>
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                        </div>
                    </div>
                    ";  
                }
            ?>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" onclick="showCustomAlert()" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="student.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function(){
        $('#orgName').on('change', function(){
            var orgID = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'get_types.php',
                data: { orgID: orgID },
                success: function(response){
                    $('#typeRSO').html(response);
                }
            });
        });
    });
</script>
<script>
  function getCollege(college) {
    if (college == "") {
      document.getElementById("courseS").innerHTML = "<option value=''>Select State</option>";
      return;
    }

    // Use AJAX to fetch states based on the selected country
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("courseS").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "get_college.php?college=" + college, true);
    xmlhttp.send();
  }
</script>

<script>
  function showCustomAlert() {
    // Customized alert with options
    Swal.fire({
    position: "top-end",
    icon: "success",
    title: "Data has been saved",
    showConfirmButton: false,
    timer: 1500
});
  }
</script>
<script>
  function delayedRedirect(event) {
    
    event.preventDefault();

   
    setTimeout(function() {
      
      event.target.submit();
    }, 2000); 
}
</script>

</body>
</html>