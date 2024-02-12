<?php
session_start();
include "db_conn.php";

$studentID = $_GET['studentID'];

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";


$conn = new mysqli($sname, $uname, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}
$firstName = "";
$middleName = "";
$lastName = "";

$userName = "";
$password = "";

$errorMessage = "";
$successMessage = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
     
        $userName = $_POST["userName"];
        $passWord = $_POST["passWord"];



        $dsn = 'mysql:host=127.0.0.1;dbname=lazaca';
        $username = 'root';
        $password = '';
    
        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Additional configuration if needed
    
            // Now $pdo is your PDO connection object
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    
    
    
    $query = $pdo->prepare("SELECT * FROM studenttable where userName = ?");
    $query->execute([$userName]);
    $result = $query->rowCount();
  

    $sql2 = "SELECT * FROM studenttable WHERE studentID = '$studentID'";
    $query2 = $conn -> query($sql2);
    $row2 = $query2 -> fetch_assoc();
    $studentName = $row2['firstName'].' '.$row2['middleName'].' '.$row2['lastName'];
        
        do{
        if (empty($userName)||empty($passWord)){
                $errorMessage = "All the fields are required";
                break;
        }else if($result > 0){

            echo "<span class='text-danger'>Username has already existed! Please choose another USERNAME </span>";


        }else{
        $sql = "UPDATE studenttable SET userName = '$userName', passWord = '$passWord', Status = 'Active' WHERE studentID = '$studentID'";
        $query = $conn -> query($sql);

        logActivity('0', $date, 'Create', 'User activated the account of '."$studentName", $time);

        $_SESSION['succes'] = 'Successfully time in';   
        header("Location: student.php");   
      
        if(!$query){
            echo "ERROR!";
        }
    }
    }while(false);

}
    $sql1 = "SELECT * FROM studenttable WHERE studentID = '$studentID'";
    $query1 = $conn -> query($sql1);
    $row = $query1 -> fetch_assoc();
    
    

   



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD ACCOUNT</title>
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
        <h2>ADD ACCOUNT</h2>
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
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">ID Number</label>
                <div class="col-sm-6">
                    <?php echo $studentID?>
                </div>   
            </div>
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-6">
                   <?php echo $row['firstName']?>
                </div>   
            </div>
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">Middle Name</label>
                <div class="col-sm-6">
                    <?php echo $row['middleName']?>
                </div>   
            </div>
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-6">
                    <?php echo $row['lastName']?>
                </div>   
            </div>
            <?php if(($row['userName'] != null) AND ($row['passWord'] != null)){ ?>

            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="userName" readonly id="userName" value="<?php echo $row['userName']?>">
                </div>   
            </div>
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="passWord" readonly id="passWord" value ="<?php echo $row['passWord']?>">
                </div>
            </div>
<?php   }else{    ?>
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="userName" required id="userName" value="<?php echo $row['userName']?>">
                </div>   
            </div>
            <div class="row mb-3">
                <label for="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="passWord" required id="passWord" value ="<?php echo $row['passWord']?>">
                </div>
            </div>

<?php   }      




?>
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
                    <?php 
                        if(($row['userName'] != null) AND ($row['passWord']) != null){  ?>
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" disabled class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                <a class="btn btn-outline-danger" href='delete_account.php?studentID=<?php echo $row['studentID']?>' role="button">DELETE ACCOUNT</a>
                </div>
                <?php }else{    ?>
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <?php }?>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="student.php" role="button" >Cancel</a>
                </div>
                
            </div>

        </form>

        <?php

           



        ?>
    </div>
</body>
</html>