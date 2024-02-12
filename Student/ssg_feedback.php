<?php
session_start();
if(isset($_GET['eventID'])) {
    $eventID = $_GET['eventID'];
    
}

if (isset($_GET['studentID'])) {
    $studentID = $_GET['studentID'];

} else {
    echo "No value received";
}



$orgID = $_SESSION['orgID'];

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";



$conn = mysqli_connect($sname, $uname, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$sql1 = "SELECT * FROM attentable WHERE attentable.studentID = '$studentID'";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($result1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="feedback-form">
        <h2>Feedback Form</h2>
        <form method="POST">
          <div class="navbar-header">
          <input type="text" name="text" id="text" readonly="" value="<?php echo $row1['StudentName']; ?>" class="form-control">
          </div>

            <div class="form-group">
                <label for="satisfaction">Satisfaction Rate:</label>
                <select name="satisfaction" id="satisfaction" required>
                    <option value="">Select Satisfaction</option>
                    <option value="5">Very Satisfied</option>
                    <option value="4">Satisfied</option>
                    <option value="3">Neutral</option>
                    <option value="2">Unsatisfied</option>
                    <option value="1">Very Unsatisfied</option>
                </select>
            </div>
            <div class="form-group">
                <label for="suggestion">Suggestion:</label>
                <textarea name="suggestion" id="suggestion" rows="4" cols="50" placeholder="Enter your suggestion"></textarea>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" id="submit" value="Submit">

                <button><a href="student_attendance.php">CANCEL</a></button>
            </div>
          </form>
    </div>

    <?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $satisfaction = $_POST['satisfaction'];
    $suggestion = $_POST['suggestion'];


    if (isset($_GET['studentID'])) {
        $studentID = mysqli_real_escape_string($conn, $_GET['studentID']);

        // Fetch existing record based on studentID
        $sql_select = "SELECT * FROM attentable WHERE studentID = '$studentID'";
        $result_select = mysqli_query($conn, $sql_select);

        if ($result_select && mysqli_num_rows($result_select) > 0) {
            // If record exists, proceed with the update
            $sql_update = "UPDATE attentable SET satRate = '$satisfaction', sugComment = '$suggestion' WHERE studentID = '$studentID' AND eventID = '$eventID'";
            $result_update = mysqli_query($conn, $sql_update);

            if ($result_update) {
                // Redirect to home.php after successful update
                header('Location: /SSG/Student/student_attendance.php');
                exit();
            } else {
                // Handle update failure
                echo "Error updating record: " . mysqli_error($conn);
            }
        } else {
            // Handle no existing record found for the given studentID
            echo "No record found for studentID: " . htmlspecialchars($studentID);
        }
    } else {
        // Handle missing studentID
        echo "No studentID received";
    }
}

?>

</body>
<script>


</script>

</html>
