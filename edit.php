<?php
include "db_conn.php";

$orgID = "";
$orgName = "";
$firstName = "";
$middleName = "";
$lastName = "";
$position = "";
$contactNo = "";
$typeRSO = "";
$natureRSO = "";
$userName = "";
$passWord = "";


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

    if(!isset($_GET["orgID"])){
        header("location: rso.php");
        exit;
    }

    $orgID = $_GET["orgID"];

    $sql = "SELECT * FROM rsotable WHERE orgID = $orgID";
    $result = $conn ->query($sql);
    $row = $result->fetch_assoc();
    
 
    if(!$row){
        header("location: rso.php");
        exit;
    }

    $orgName = $row["orgName"];
    $firstName = $row["firstName"];
    $middleName = $row["middleName"];
    $lastName = $row["lastName"];
    $position = $row["position"];
    $contactNo = $row["contactNo"];
    $typeRSO = $row["typeRSO"];
    $natureRSO = $row["natureRSO"];
    $userName = $row["userName"];
    $passWord = $row["passWord"];
    
        

}
else{
        
        $orgID = $_POST["orgID"];
        $orgName = $_POST["orgName"];
        $firstName = $_POST["firstName"];
        $middleName = $_POST["middleName"];
        $lastName = $_POST["lastName"];
        $position = $_POST["position"];
        $contactNo = $_POST["contactNo"];
        $typeRSO = $_POST["typeRSO"];
        $natureRSO = $_POST["natureRSO"];
        $userName = $_POST["userName"];
        $passWord = $_POST["passWord"];
        

        do{
            if(empty($orgID)||empty($orgName)||empty($firstName)||empty($lastName)||empty($position)||empty($contactNo) ||empty($typeRSO)||empty($natureRSO)
            ||empty($userName)||empty($passWord)){
                $errorMessage = "All the fields are required";
                break;
        }
//add new client to database

        $sql = "UPDATE rsotable " .
            "SET orgName = '$orgName', firstName = '$firstName', middleName = '$middleName', lastName = '$lastName', position = '$position', contactNo = '$contactNo', userName = '$userName', passWord='$passWord', typeRSO = '$typeRSO', natureRSO='$natureRSO'" .
            "WHERE orgID =$orgID";

        $result = $conn->query($sql);

        logActivity('0', $date, 'Update', 'User updated the RSO '."$orgName", $time);

        if(!$result){
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }

        $successMessage = "Client Updated Correctly!";

        header("location: rso.php");
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

</head>
<body>
    <div class="container my-5">
        <h2>UPDATE RSO USER</h2>
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
            <input type="hidden" name="orgID"  value="<?php echo $orgID; ?>">
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">ORGANIZATION NAME</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="orgName" value="<?php echo $orgName;?>">
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
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">POSITION</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="position" value="<?php echo $position;?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">CONTACT</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contactNo" value="<?php echo $contactNo;?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label" class="txt">TYPE OF RSO</label> <br><br>
                <select name="typeRSO" id="typeRSO">
                    <option value="">--- Choose the type of RSO ---</option>
                    <option value="Non-Academic">Non-Academic</option>
                    <option value="Academic">Academic</option>
                </select> <br><br>
            </div>
            <div class="row mb-3">
        <label for="col-sm-3 col-form-label" class="txt">NATURE OF RSO</label> <br><br>
        <select name="natureRSO" id="natureRSO">
            <option value="">--- Choose the Nature of RSO ---</option>
            <?php
                // PHP code to generate initial options for natureRSO dropdown
                $nonAcademicOptions = ["Civic", "Religious", "Sports", "Others"];
                $academicOptions = ["Department Student Council", "College Student Council"];

                foreach ($nonAcademicOptions as $option) {
                    echo '<option value="' . $option . '">' . $option . '</option>';
                }

                // The academic options are added via JavaScript based on user selection
            ?>
        </select> <br><br>
    </div>
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">USERNAME</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="userName" value="<?php echo $userName;?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">PASSWORD</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="passWord" value="<?php echo $passWord;?>">
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
                    <a class="btn btn-outline-primary" href="rso.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    <script>
        // Add event listener to the first dropdown
        document.getElementById("typeRSO").addEventListener("change", function() {
            // Get the selected value
            var selectedValue = this.value;

            // Get the second dropdown
            var natureDropdown = document.getElementById("natureRSO");

            // Clear existing options
            natureDropdown.innerHTML = '<option value="">--- Choose the Nature of RSO ---</option>';

            // Add new options based on the selected value
            if (selectedValue === "Non-Academic") {
                // Add non-academic options
                var nonAcademicOptions = ["Civic", "Religious", "Sports", "Others"];
                nonAcademicOptions.forEach(function(option) {
                    natureDropdown.innerHTML += '<option value="' + option + '">' + option + '</option>';
                });
            } else if (selectedValue === "Academic") {
                // Add academic options
                var academicOptions = ["Department Student Council", "College Student Council"];
                academicOptions.forEach(function(option) {
                    natureDropdown.innerHTML += '<option value="' + option + '">' + option + '</option>';
                });
            }
        });
    </script>
</body>
</html>