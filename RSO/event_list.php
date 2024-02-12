<?php
session_start();
$orgID = $_SESSION['orgID'];




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LIST OF ATTENDANCE</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" type="text/css" />
    <style>
        th, td {
            text-align: center;
            white-space: nowrap;
        }
        .option-margin-left {
            margin-left: 100px;
        }
        @media print {
            body * {
                visibility: visible;
            }
            #tableid, #tableid th, #tableid td, #tableid tr, #attendanceData {
                visibility: visible;
            }
            th, td {
                border: 1px solid #000;
                padding: 6px;
            }
        }
    </style>
</head>
<body>

<br><h1>EVENT</h1><br>
<form method="POST">
<select id="eventDropdown" class="dropdown-options" name="eventDropdown">
    <option value="">CHOOSE</option>
    <!-- Dropdown options will be populated dynamically -->
    <?php
    // Establish database connection
    $sname = "127.0.0.1";
    $uname = "root";
    $password = "";
    $db_name = "lazaca";
    $conn = new mysqli($sname, $uname, $password, $db_name);

    // Query to fetch event descriptions from the database
    $sql = "SELECT DISTINCT eventDescription FROM rso_attentable WHERE orgID = '$orgID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $selected = ($_POST['eventDropdown'] ?? '') == $row['eventDescription'] ? 'selected' : '';
            echo "<option value='" . $row['eventDescription'] . "' $selected>" . $row['eventDescription'] . "</option>";
        }
    } else {
        echo "<option value=''>No events found</option>";
    }
    ?>
</select>
<input type="submit" value="REFRESH">
</form>

<div class="container my-5">
    <h2>LIST OF ATTENDANCE</h2>
    <table id="tableid" class="table-striped table compact" style="width:100%">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">ID Number</th>
                <th scope="col">Student Name</th>
                <th scope="col">Time In</th>
                <th scope="col">Time Out</th>
                <th scope="col">Log Date</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody id="attendanceData" name="attendanceData">
            <?php 
            if (!empty($_POST['eventDropdown'])) {
                $counter = 0;
                $eventDescription = $_POST['eventDropdown'];
                $sql = "SELECT * FROM rso_attentable WHERE eventDescription = '$eventDescription' and orgID = '$orgID'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $counter++;
                        echo "<tr>";
                        echo "<td>".$counter."</td>";
                        echo "<td>".$row['idNumber']."</td>";
                        echo "<td>".$row['StudentName']."</td>";
                        echo "<td>".$row['TimeIn']."</td>";
                        echo "<td>".$row['TimeOut']."</td>";
                        echo "<td>".$row['LogDate']."</td>";
                        echo "<td>".$row['Status']."</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No attendance records found</td></tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <a class="btn btn-danger" href="home.php" role="button">BACK</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert@2"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js" type="text/javascript"></script>

<script>
$(document).ready(function() {
    var table = $('#tableid').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', {
                extend: 'print',
                text: 'Print', // Custom text for print button
                customize: function(win) {
                    $(win.document.body).find('table').addClass('display').css('font-size', '9px');
                    $(win.document.body).find('tr:nth-child(odd) td').each(function(index) {
                        $(this).css('background-color', '#D0D0D0');
                    });
                    $(win.document.body).find('h1').css('text-align', 'center').css('font-size', '18px').css('margin-bottom', '20px');
                }
            }
        ],
        "columnDefs": [{
                "className": "dt-center",
                "targets": "_all"
            },
            {
                "orderable": false,
                "targets": "_all"
            }
        ],
        "searching": false
    });
});
</script>

</body>
</html>
