
 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Convert | Export html Table to CSV & EXCEL File</title>
    <link rel="stylesheet" type="text/css" href="style4.css">
</head>

<body>
    <main class="table" id="customers_table">
        <section class="table__header">
            <h1>Activity Logs</h1>
            <a href="home.php" class="btn btn-danger" > BACK </a>
            
           
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Id <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Date <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Activity <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Description <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Time <span class="icon-arrow">&UpArrow;</span></th>
                        
                    </tr>
                </thead> 
                <?php 
                                $sname = "127.0.0.1";
                                $uname = "root";
                                $password = "";
                                $db_name = "lazaca";
                
                                $conn = new mysqli($sname, $uname, $password, $db_name);
                $i = 0;
                $sql = "SELECT * FROM activity_history where orgID = '0'";
                $result = $conn->query($sql);

                if(!$result){
                    die("Invalid query: " .$conn->error);
                }


                while($row = $result->fetch_assoc()){
                $i++;
                echo "
                <tr>
                        <td>$i</td>
                        <td>$row[ActDate]</td>
                        <td>$row[ActType]</td>
                        <td>$row[ActDescription]</td>
                        <td>$row[ActTime]</td>
                </tr>                        
                        ";
                }

                        ?>
                <tbody>
                    
                    
                </tbody>
            </table>
        </section>
    </main>
    <script src="activity_log.js"></script>

</body>

</html>