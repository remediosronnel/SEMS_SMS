<?php
// Initialize session
session_start();

// Database configuration
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "lazaca";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if organization ID is set in session
if(isset($_SESSION['orgID'])) {
    $orgID = $_SESSION['orgID'];

    // Fetch events for the organization with feedback
    $sql = "SELECT e.*, a.satRate, a.sugComment 
            FROM eventtable e 
            LEFT JOIN attentable a ON e.eventID = a.eventID AND a.orgID = e.orgID 
            WHERE e.orgID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orgID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Close prepared statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RSO Event</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        td {
            text-align: center;
        }
    </style>
</head>
<body>
    <main class="table" id="customers_table">
        <section class="table__header">
            <h1>EVENT LIST</h1>
            <div class="export__file">
                <label for="export-file" class="export__file-btn" title="Export File"></label>
                <input type="checkbox" id="export-file">
            </div>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Event ID </th>
                        <th> Recipient </th>
                        <th> Org Name </th>
                        <th> Event Description </th>
                        <th> Event Date </th>
                        <th> Event Time </th>
                        <th> Feedbacks</th>
                        <th> Action </th>
                        <th> Attendance </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    while ($row = $result->fetch_assoc()) {
                        $i++;
                        $eventTime = new DateTime($row['eventTime']);
                        $time = $eventTime->format("h:i:s");
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $row['recePient'] ?></td>
                        <td><?php echo $row['orgName'] ?></td>
                        <td><?php echo $row['eventDescription'] ?></td>
                        <td><?php echo $row['eventDate'] ?></td>
                        <td><?php echo $time ?></td>
                        <td>
                            <?php
                            if(!empty($row['satRate']) || !empty($row['sugComment'])) {
                                echo '<a class="btn btn-primary btn-sm" href="SSG_feedback.php?eventID='.$row['eventID'].'">Feedback</a>';
                            }
                            ?>
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="edit_event.php?eventID=<?php echo $row['eventID']; ?>">EDIT</a>
                            <a class="btn btn-danger btn-sm" href="delete_event.php?eventID=<?php echo $row['eventID']; ?>">DELETE</a>
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="attendance.php?eventID=<?php echo $row['eventID']; ?>">OPEN</a>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr><a href="/SSG/home.php" class="fcc-btn">BACK</a></tr>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
