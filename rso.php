<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADDING RSO</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" type="text/css" rel="stylesheet" />
    <style>
        th, td{
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="container my-5">
        <h2>LIST OF RSO</h2>
        <br>
        <table id="tableid" class="table-striped table compact" style="width:100%">
            <thead>
                <tr>
                    <th>Org ID</th>
                    <th>Organization Name</th> 
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Org Position</th>
                    <th>Contact Number</th>
                    <th>Type RSO</th>
                    <th>Nature RSO</th>
                    <th>User Name</th>
                    <th>Password</th>
                    <th>Action</th>    
                </tr>
            </thead>
            <tbody>
                <?php
                include "db_conn.php";
                $i = 0;
                $sname = "127.0.0.1";
                $uname = "root";
                $password = "";
                $db_name = "lazaca";

                $conn = new mysqli($sname, $uname, $password, $db_name);

                if (!$conn) {
                    echo "Connection failed!";
                }
                $sql = "SELECT * FROM rsotable";
                $result = $conn->query($sql);

                if(!$result){
                    die("Invalid query: " .$conn->error);
                }

                logActivity('0', $date, 'Navigate', 'User watching list of RSO ', $time);
                while($row = $result->fetch_assoc()){
                    $i++;
                    echo "
                        <tr>
                        <td>$i</td>
                        <td>$row[orgName]</td>
                        <td>$row[firstName]</td>
                        <td>$row[middleName]</td>
                        <td>$row[lastName]</td>
                        <td>$row[position]</td>
                        <td>$row[contactNo]</td>
                        <td>$row[typeRSO]</td>
                        <td>$row[natureRSO]</td>
                        <td>$row[userName]</td>
                        <td>$row[passWord]</td>
                        <td> 
                            <a class='btn btn-primary btn-sm' href='edit.php?orgID=$row[orgID]'>EDIT</a>"?>

                        <div class="delete">
                        <a href="#" class="btn btn-danger deleteButton" data-orgid="<?php echo $row['orgID']; ?>">Delete</a>
                        </div>
                
                <?php echo "
                        </td>
                        </tr> 
                        ";
                                    }
                ?>
            </tbody>
            
        </table>
        <a class="btn btn-primary" href="create.php" role="button">New RSO User</a>
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
                                window.location.href = "delete.php?orgID=" + orgID;
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