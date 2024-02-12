<?php
session_start();
include "db_conn.php";

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$i=0;
$s=0;
$orgID = "";

$conn = new mysqli($sname, $uname, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$orgID = $_SESSION['orgID'];

$sql = "SELECT * FROM rsotable WHERE rsotable.orgID='$orgID'";
$result = $conn->query($sql);

if (!$result) {
    die("Invalid query: " . $conn->error);
}

$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDENT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        * {
            margin-left: 20px;
            margin-right: 20px;
        }
        .class {
            width: 100px;
        }

        div.dataTables_wrapper {
            margin-bottom: 3em;
        }
        #back{
            margin-left: 100px;
            width: 100px;
            margin-bottom: 10px;
        }

    </style>
</head>

<body>
    <h1>SSG LIST</h1>
    <a class="btn btn-primary btn-sm" id="back" role="button" href="student.php"> BACK </a>

    <table id="tableid1" class="display" style="width:90%">
    
        
        <thead>
            <tr>
                <th>No</th>
                <th>idNumber</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Year Level</th>
                <th>Contact No</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM studenttable";
            $result = $conn->query($sql);

            if (!$result) {
                die("Invalid query: " . $conn->error);
            }
            while ($row = $result->fetch_assoc()) {
                $i++;
                echo "
                    <tr>
                        <td>{$i}</td>
                        <td>{$row['idNumber']}</td>
                        <td>{$row['firstName']} {$row['middleName']} {$row['lastName']}</td>
                        <td>{$row['courseS']}</td>
                        <td>{$row['yearLevel']}</td>
                        <td>{$row['contactNo']}</td>
                        <td><a href='#' class='btn btn-primary addButton' onclick=\"confirmAdd('{$row['studentID']}')\">ADD</a></td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>

    <h1>YOUR LIST</h1>
    <table id="tableid2" class="display" style="width:90%">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Number</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Year Level</th>
                <th>Contact No</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
         

            $sql1 = "SELECT * FROM studentorgtable where org1 = '$orgID'";
            $result1 = $conn->query($sql1);

            if (!$result1) {
                die("Invalid query: " . $conn->error);
            }
            while ($row1 = $result1->fetch_assoc()) {
                $s++;
                echo "
                        <tr>
                        <td>{$s}</td>
                        <td>{$row1['idNumber']}</td>
                        <td>{$row1['firstName']} {$row1['middleName']} {$row1['lastName']}</td>
                        <td>{$row1['courseS']}</td>
                        <td>{$row1['yearLevel']}</td>
                        <td>{$row1['contactNo']}</td>
                        <td><a href='#' class='btn btn-danger deleteButton' onclick=\"confirmDelete('{$row1['studentID']}')\">DELETE</a></td>
                        </tr>";
            }

           
            ?>
        </tbody>
        
    </table>

    <script>
        $(document).ready(function() {
            $('#tableid1').DataTable();
            $('#tableid2').DataTable();
        });
    </script>
    <script>
     function confirmAdd(studentID) {
            var confirmation = confirm("Are you sure you want to add this student?");
            
            if (confirmation) {
                // AJAX request to add the student
                $.ajax({
                    type: "POST",
                    url: "add_student2.php", // Create a PHP file to handle the addition
                    data: { studentID: studentID },
                    success: function(response) {
                        // Reload the tables or update the UI as needed
                        alert("Student added successfully!");
                        location.reload(); // Reload the page for simplicity, you may update the UI without a full reload
                    },
                    error: function(error) {
                        console.error("Error adding student: ", error);
                    }
                });
            }
        }
    </script>
    <script>
    // Function to confirm and delete a student
    function confirmDelete(studentID) {
        var confirmation = confirm("Are you sure you want to delete this student?");
        
        if (confirmation) {
            // AJAX request to delete the student
            $.ajax({
                type: "POST",
                url: "delete_student.php", // Create a PHP file to handle the deletion
                data: { studentID: studentID },
                success: function(response) {
                    // Reload the page or update the UI as needed
                    alert("Student deleted successfully!");
                    location.reload(); // Reload the page for simplicity, you may update the UI without a full reload
                },
                error: function(error) {
                    console.error("Error deleting student: ", error);
                }
            });
        }
    }
</script>
</body>

</html>
