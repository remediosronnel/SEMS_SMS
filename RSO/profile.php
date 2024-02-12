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

$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rsotable WHERE orgID = $orgID"));

$errorMessage = "";
$successMessage = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process form data
    $firstName = $_POST["firstName"];
    $middleName = $_POST["middleName"];
    $lastName = $_POST["lastName"];
    $position = $_POST["position"];
    $contactNo = $_POST["contactNo"];
    $userName = $_POST["userName"];
    $passWord = $_POST["passWord"];

    // Validate and update database
    do {
        if (empty($userName) || empty($passWord)) {
            $errorMessage = "All the fields are required";
            break;
        } else {
            // Update user information
            $sql = "UPDATE rsotable SET firstName = '$firstName', middleName = '$middleName', lastName = '$lastName', position = '$position', contactNo = '$contactNo', userName = '$userName', passWord = '$passWord' WHERE orgID = '$orgID'";
            $query = $conn->query($sql);

            logActivity($orgID, $date, 'Update', 'User updated user profile', $time);

            // Check if the query was successful
            if (!$query) {
                $errorMessage = "Error updating user information";
                break;
            }

            // Handle photo upload
            if (isset($_FILES["image"]["name"])) {
                $imageName = $_FILES["image"]["name"];
                $imageSize = $_FILES["image"]["size"];
                $tmpName = $_FILES["image"]["tmp_name"];

                $validImageExtension = ['jpg', 'jpeg', 'png'];
                $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);

                if (!in_array(strtolower($imageExtension), $validImageExtension)) {
                    $errorMessage = "Invalid Image Extension";
                    break;
                } elseif ($imageSize > 1200000) {
                    $errorMessage = "Image Size Is Too Large";
                    break;
                }

                // Generate a unique name for the image
                $newImageName = $orgID . "-" . date("Y.m.d-H.i.s") . "." . $imageExtension;

                // Update the database with the new image name
                $sqlUpdateImage = "UPDATE rsotable SET image = '$newImageName' WHERE orgID = '$orgID'";
                $queryUpdateImage = $conn->query($sqlUpdateImage);

                logActivity($orgID, $date, 'Update', 'User updated organization logo', $time);
                
                if (!$queryUpdateImage) {
                    $errorMessage = "Error updating image information";
                    break;
                }

                // Move the uploaded image to the "img" directory
                move_uploaded_file($tmpName, 'img/' . $newImageName);
            }

            $successMessage = "User information updated successfully";
            header("Location: home.php");
        }
    } while (false);
}

// Retrieve user information
$sql1 = "SELECT * FROM rsotable WHERE orgID = '$orgID'";
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
                <?php
                $id = $user["orgID"];
                $name = $user["orgName"];
                $image = $user["image"];



                if (!empty($image) && file_exists("img/$image")) { ?>
                    <img src="img/<?php echo $image; ?>" width="150" height="150" title="' . $image . '" id="previewImage">
     <?php           } else {  ?>
                  
                    <img src="/SSG/RSO/img/Upload_logo.png" width="150" height="150" title="Default Image" >
    <?php
                }
                ?>




                
                <div class="round">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="name" value="<?php echo $name; ?>">
                    <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" class="class1" onchange="displayImage()">
                    <i class="fa fa-camera" style="color: #fff;"></i>
                    <!-- Add delete button -->
                    <button type="button" class="btn btn-danger" onclick="deleteImage()">Delete</button>
                </div>
        <div class="row mb-3">
            <label for="col-sm-3 col-form-label">ID Number</label>
            <div class="col-sm-6">
                <?php echo $orgID ?>
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
            <label for="col-sm-3 col-form-label">Position</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="position" id="position"
                       value="<?php echo $row['position'] ?>">
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
    </form>

    <script type="text/javascript">
        function displayImage() {
            var input = document.getElementById('image');
            var preview = document.getElementById('previewImage');
            var reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }

        function deleteImage() {
                var preview = document.getElementById('previewImage');
                var input = document.getElementById('image');

                // Reset the input and preview
                input.value = '';
                preview.src = 'img/placeholder.png'; // Set to a placeholder or an empty image path
            }
</script>
</div>
</body>
</html>