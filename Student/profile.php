<?php 
session_start();
$studentID = $_SESSION['studentID'];

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = new mysqli($sname, $uname, $password, $db_name);

if (!$conn) {
    echo "Connection failed!";
}



$errorMessage = "";
$successMessage = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process form data
    $firstName = $_POST["firstName"];
    $middleName = $_POST["middleName"];
    $lastName = $_POST["lastName"];
    $yearLevel = $_POST["yearLevel"];
    $courseS = $_POST["courseS"];
    $contactNo = $_POST["contactNo"];
    $userName = $_POST["userName"];
    $passWord = $_POST["passWord"];
    

    // Validate and update database
    do {
        if (empty($contactNo) ) {
            $errorMessage = "All the fields are required";
            break;
        } else {
            // Update user information
            $sql = "UPDATE studenttable SET firstName = '$firstName', middleName = '$middleName', lastName = '$lastName', yearLevel = '$yearLevel', courseS = '$courseS', contactNo = '$contactNo', userName = '$userName', passWord = '$passWord' WHERE studentID = '$studentID'";
            $query = $conn->query($sql);

            // Check if the query was successful
            if (!$query) {
                $errorMessage = "Error updating user information";
                break;
            }


            $successMessage = "User information updated successfully";
            header("Location: home.php");
        }
    } while (false);
}

// Retrieve user information
$sql1 = "SELECT * FROM studenttable WHERE studentID = '$studentID'";
$query1 = $conn->query($sql1);
$row = $query1->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD ACCOUNT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <h2>PROFILE</h2>
        <?php
    if (!empty($errorMessage)) {
        echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        ";
    } elseif (!empty($successMessage)) {
        echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>$successMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        ";
    }
    ?>

        
             
<form method="post" enctype="multipart/form-data" id="userInfoForm">

<div class="upload">
                
        <div class="row mb-3">
            <label for="col-sm-3 col-form-label">ID Number</label>
            <div class="col-sm-6">
                <?php echo $studentID ?>
            </div>
        </div>
        <div class="row mb-3">
            <label for="col-sm-3 col-form-label">First Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="firstName" id="firstName"
                       value="<?php echo $row['firstName'] ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="col-sm-3 col-form-label">Middle Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="middleName" id="middleName"
                       value="<?php echo $row['middleName'] ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="col-sm-3 col-form-label">Last Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="lastName" id="lastName"
                       value="<?php echo $row['lastName'] ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="col-sm-3 col-form-label">Course</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="courseS" id="courseS"
                       value="<?php echo $row['courseS'] ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="col-sm-3 col-form-label">Course</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="yearLevel" id="yearLevel"
                       value="<?php echo $row['yearLevel'] ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="col-sm-3 col-form-label">Contact</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="contactNo" id="contactNo"
                       value="<?php echo $row['contactNo'] ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="col-sm-3 col-form-label">Username</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="userName" id="userName"
                       value="<?php echo $row['userName'] ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="passWord" id="passWord"
                       value="<?php echo $row['passWord'] ?>">
            </div>
        </div>
    



        <div class="row mb-3">
            <div class="col-sm-3 d-grid">
            </div>
            <div class="offset-sm-3 col-sm-3 d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="col-sm-3 d-grid">
                <a class="btn btn-outline-primary" href="home.php" role="button">Cancel</a>
            </div>
        </div>
    </div>
    </form>

    

</body>
</html>