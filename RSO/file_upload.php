<?php 
require 'function.php';
include 'db_conn.php';

$orgID = $_SESSION['orgID'];
?>

<html>
<head></head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
<style>
    img{
        width: 100px;
        height: 100px;
    }
    table{
        margin: 0 auto; 
    }

    #back{
        width: 100px;
        margin-left: 100px;    
    }



</style>
<body>
    <h1>OFFICERS</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <td>#</td>
            <td>Name</td>
            <td>Position</td>
            <td>Image</td>
            <td>Action</td>
        </tr>
        <?php
        $users = mysqli_query($conn, "SELECT * FROM officertable where orgID = '$orgID'");
        $i = 1;
        
        foreach($users as $user) :
        ?> 
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $user['officer_name'] ?></td>
            <td><?php echo $user['officer_position']; ?></td>
            <td><img src="img/RSO_image/<?php echo $user['image_path'];?>"></td>

            <td style="display: flex; flex-direction: column; align-items: flex-start;">
                    <a class='btn btn-primary btn-sm mb-2' href="officers_edit.php?id=<?php echo $user['officerID']; ?>">Edit</a>
                <form class="" action="" method="post">
                    <button type="submit" name="submit" class='btn btn-danger btn-sm' value="<?php echo $user['officerID']; ?>">Delete </button>
                </form>
                <input type="hidden" id="id" name="id" value="<?php echo $user['officerID']; ?>">
            </td>
        </tr>
        <?php endforeach; 
        logActivity($orgID, $date, 'Navigation', 'User check the list of Officers', $time);
        ?>
        
    </table>
        <a type="button" id="back" name="back" class='btn btn-danger' href="officers.php">BACK</a>
</body>
</html>
