<?php
session_start();
$studentID = $_SESSION['studentID'];

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";



$conn = mysqli_connect($sname, $uname, $password, $db_name);

?>

<!DOCTYPE html>
<html>
<head>
    <title>OFFICERS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        img {
            max-width: 100px;
            max-height: 100px;
            display: block;
            margin: 0 auto;
        }

        table {
            margin: 20px auto;
        }

        p {
            font-family: Arial, sans-serif;
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        table td, tr{
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <a type="button" id="back" name="back" class="btn btn-danger" href="home.php">BACK</a>
            </div>
        </div>

        <?php
        $sql1 = "SELECT * FROM officertable WHERE orgID = '0'";
        $result1 = mysqli_query($conn, $sql1);
        ?>
        <div class="row">
            <div class="col">
                <p>SSG OFFICERS</p>
                <table class="table table-bordered">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Position</th>
                    </tr>
                    <?php while($row1 = mysqli_fetch_assoc($result1)) { ?>
                        <tr>
                            <td><img src="/SSG/img/<?php echo $row1['image_path'];?>" alt="Officer Image"></td>
                            <td><?php echo $row1['officer_name'] ?></td>
                            <td><?php echo $row1['officer_position']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>

        <?php
        $sql = "SELECT org1 FROM studentorgtable WHERE studentorgtable.studentID = '$studentID'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) {
            $orgID = $row['org1'];
            $sql2 = "SELECT * FROM rsotable WHERE orgID = '$orgID'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $orgName = $row2['orgName'];
        ?>
            <div class="row">
                <div class="col">
                    <p><?php echo $orgName; ?> OFFICERS</p>
                    <?php
                    $sql1 = "SELECT * FROM officertable WHERE orgID = '$orgID'";
                    $result1 = mysqli_query($conn, $sql1);
                    ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Position</th>
                        </tr>
                        <?php while($row1 = mysqli_fetch_assoc($result1)) { ?>
                            <tr>
                                <td><img src="/SSG/RSO/img/RSO_image/<?php echo $row1['image_path'];?>" alt="Officer Image"></td>
                                <td><?php echo $row1['officer_name'] ?></td>
                                <td><?php echo $row1['officer_position']; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>
