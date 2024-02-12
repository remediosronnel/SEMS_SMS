<?php
session_start();
$typeRSO = "";
$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$i=0;

$conn = mysqli_connect($sname, $uname, $password, $db_name);





$orgID = $_SESSION['orgID'];
$typeRSO = $_SESSION['typeRSO'];

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADDING STUDENT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
</head>
<body>
    <div class="container my-5">
        <h2>LIST OF MEMBERS</h2>
        <br>
        <table id="tableid" class="table-striped table compact" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Number</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Course</th>
                    <th>Year Level</th>
                    <th>Contact No</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                $sname = "127.0.0.1";
                $uname = "root";
                $password = "";
                $db_name = "lazaca";

                $conn = new mysqli($sname, $uname, $password, $db_name);

             
                if (!$conn) {
                    echo "Connection failed!";
                }
                $sql = "SELECT * FROM studentorgtable where studentorgtable.org1 = '$orgID'";
                $result = $conn->query($sql);

                if(!$sql){
                    $sql1 = "SELECT * FROM studentorgtable where studentorgtable.org2 = '$orgID'";
                    $result = $conn->query($sql1);
                    if(!$sql1){
                        $sql2 = "SELECT * FROM studentorgtable where studentorgtable.org3 = '$orgID'";
                        $result = $conn->query($sql2);
                        if(!$sql2){
                            $sql3 = "SELECT * FROM studentorgtable where studentorgtable.org4 = '$orgID'";
                            $result = $conn->query($sql3);
                            if(!$sql3){
                                $sql4 = "SELECT * FROM studentorgtable where studentorgtable.org5 = '$orgID'";
                                $result = $conn->query($sql4);
                            }
                        }
                    }
                }

             
                while($row = $result->fetch_assoc()){
                    $i++;
                    echo "
                        <tr>
                        <td>$i</td>
                        <td>$row[idNumber]</td>
                        <td>$row[firstName]</td>
                        <td>$row[middleName]</td>
                        <td>$row[lastName]</td>
                        <td>$row[courseS]</td>
                        <td>$row[yearLevel]</td>
                        <td>$row[contactNo]</td>
                        </tr>";
                }
                ?>
            </tbody>
            
        </table>
        <a class="btn btn-primary" href="add_student.php" role="button">ADD MEMBER</a>
        <a class="btn btn-danger" href="home.php" role="button">Cancel</a>
    </div>
    <script src="sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js" type="text/javascript"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
       

        $(document).ready(function() {
	        $('#').DataTable({
                "pagingType": "full_numbers",
	            "lengthMenu":  [
		            [10, 25, 50, -1],
		            [10, 25, 50, "All"]
	                            ],
	            responsibe: true,
	            language: {
		        search: "_INPUT_",
		        searchPlaceholder: "Search records",
                
            	}	
            });
        });        
    </script>
     <script>
        $(document).ready(function() {
            $('#tableid').DataTable( {
            dom: 'Bfrtip',
            buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
            ]
            } );
        } );            

    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.deleteButton').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                
                var studentID = this.getAttribute('data-studentid');
                var orgID = this.getAttribute('data-orgid');
                
                swal({
                    title: "Delete selected item?",
                    text: "Unrecoverable Data",
                    icon: "warning",
                    buttons: true,
                    dangerMode: "true",
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal({
                            title: "Delete Data Successfully",
                            icon: "success"
                        }).then(okay => {
                            if (okay) {
                                window.location.href = "delete_student.php?studentID=" + studentID + "&orgID=" + orgID;
                            }
                        });
                    } else {
                        swal({
                            title: "Data Not Deleted",
                            icon: "error",
                        });
                    }
                });
            });
        });
    });
</script>
</body>

</html>