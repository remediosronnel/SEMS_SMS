<?php
include "db_conn.php";

$idNumber = "";
$studentID = "";
$firstName = "";
$middleName = "";
$lastName = "";
$courseS = "";
$yearLevel = "";
$contactNo = "";
$status = "";

$errorMessage = "";
$successMessage = "";


$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = new mysqli($sname, $uname, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}


if($_SERVER['REQUEST_METHOD'] == 'GET'){

    if(!isset($_GET["studentID"])){
        header("location: student.php");
        exit;
    }

    $studentID = $_GET["studentID"];

    $sql = "SELECT * FROM studenttable WHERE studentID = $studentID";
    $result = $conn ->query($sql);
    $row = $result->fetch_assoc();
    
 
    if(!$row){
        header("location: student.php");
        exit;
    }

    $idNumber = $row["idNumber"];
    $firstName = $row["firstName"];
    $middleName = $row["middleName"];
    $lastName = $row["lastName"];
    $courseS = $row["courseS"];
    $yearLevel = $row["yearLevel"];
    $contactNo = $row["contactNo"];
    
    $status = $row["Status"];
        

}
else{
    $studentID = $_GET["studentID"];
    $sql = "SELECT * FROM studenttable WHERE studentID = $studentID";
    $result = $conn ->query($sql);
    $row = $result->fetch_assoc();
    
       
        $idNumber = $_POST["idNumber"];
        $studentID = $_POST["studentID"];
        $firstName = $_POST["firstName"];
        $middleName = $_POST["middleName"];
        $lastName = $_POST["lastName"];
        $courseS = $_POST["courseS"];
        $yearLevel = $_POST["yearLevel"];
        $contactNo = $_POST["contactNo"];

        $status =  $row["Status"];

        do{
            if(empty($idNumber)||empty($studentID)||empty($firstName)||empty($lastName)||empty($courseS)||empty($yearLevel) ||empty($contactNo)){
                $errorMessage = "All the fields are required";
                break;
        }
//add new client to database

        $sql = "UPDATE studenttable " .
            "SET idNumber = '$idNumber',firstName = '$firstName', middleName = '$middleName', lastName = '$lastName', courseS = '$courseS', yearLevel = '$yearLevel', contactNo = '$contactNo', Status = '$status'" .
            "WHERE studentID =$studentID";

        $result = $conn->query($sql);

        logActivity('0', $date, 'Update', 'User updated the Student '."$firstName $middleName $lastName", $time);

        if(!$result){
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }

        $successMessage = "Client Updated Correctly!";

        header("location: student.php");
        exit;

    }while (true);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSO</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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
        <h2>UPDATE STUDENT</h2>
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
 
        <form method="post">
            
            

          

           
            <input type="hidden" name="studentID"  value="<?php echo $studentID; ?>">
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
                    <option value="CBA">CBA</option>
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
                <label for="col-sm-3 col-form-label">Year Level</label>
                <div class="col-sm-6">
                    <select id="yearLevel" name="yearLevel" value="<?php echo $yearLevel;?>">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="student.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
</body>
</html>