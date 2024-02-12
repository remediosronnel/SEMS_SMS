<?php
session_start();

$conn = new mysqli("127.0.0.1", "root", "", "lazaca");
$orgID = $_SESSION['orgID'];
$eventID = isset($_SESSION['eventID']);

$studentName = "";  
$studentID = "";

if($conn->connect_error){
    die("Connection failed" .$conn->connect_error) ;
}


function handleWarningAsException($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

set_error_handler('handleWarningAsException');



if(isset($_POST['text']) ){
           
    try{
        $text = $_POST['text']; 
        $arrayEvent = substr($text, 0, 3);
        $arrayOrg = substr($text, 4, 7);
        $arrayStudent = substr($text, 8, 11);
        $arrayName = substr($text, 12, 50);
        $text1 = trim((int)$arrayEvent);
        $text2 = trim((int)$arrayOrg);
        $text3 = trim((int)$arrayStudent);
        $text4 = trim($arrayName);
    
        
    $date = date('m-d-Y');
    $curDate = date('m-d-Y', strtotime('+1 day'));
    $time = date('h:i:s');


    $sql = "SELECT * FROM studenttable WHERE studenttable.studentID = '$text3'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $studentID = $row['studentID'];
   
    $voice = new COM("SAPI.SpVoice");

    $message = "Hi".$text4."Your attendance has been successfully added! Thank you!";
    

    }catch(ErrorException $e){
        $voice = new COM("SAPI.SpVoice");
        $message1 = "Unaccepted Data!!!";
        $voice ->speak($message1);
        header("Location: attendance.php"); 
        
    }
    $sql1="SELECT COUNT(studentID) AS count FROM attentable WHERE attentable.studentID = '$text3'";
    $query1 = $conn->query($sql1);
    $row1 = mysqli_fetch_assoc($query1);

    $sql = "SELECT * FROM attentable WHERE attentable.studentID = '$text3' AND attentable.LogDate = '$date' AND attentable.Status = '0'";
    $query = $conn->query($sql);
    $row = mysqli_fetch_assoc($query);

        if($query->num_rows > 0){
            $sql = "UPDATE attentable SET TimeOut = '$time', Status = '1' WHERE studentID = '$text3' AND LogDate = '$date'";
            $query = $conn -> query($sql);
            $voice -> speak($message);
            $_SESSION['succes'] = 'Successfully time in';    
            header("Location: attendance.php");    
            
        }else{
            if(($text3 == $studentID)){
                $sql = "INSERT INTO attentable(studentID, StudentName, TimeIn, LogDate, Status, orgID, eventID) VALUES('$studentID', '$text4', '$time', '$date', '0', '$orgID', '$text1')";
                if($conn -> query($sql) === true){
                    $_SESSION['success'] = 'Successfully Time In';
                    $voice ->speak($message);
                }else{
                    $_SESSION['error'] = $conn->error;
                    $voice ->speak($message1);
                }
         
                header("Location: attendance.php");
            }
        }
    }
    // else{
    //     $voice = new COM("SAPI.SpVoice");
    //     $message1 = "Unaccepted Data!!!";  
    //     $voice ->speak($message1);
    //     header("Location: attendance.php"); 
    // }
    


$conn-> close();    

?>

