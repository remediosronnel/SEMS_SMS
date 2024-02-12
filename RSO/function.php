<?php
session_start();
 


$orgID = $_SESSION['orgID'];

$conn = mysqli_connect("127.0.0.1","root","","lazaca");

if(isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST"){

	if($_POST["submit"] == "add"){
	    add();
	}else if($_POST["submit"] == "edit"){
        edit();
    }
	else{
		delete();
	}

}

function add(){
    include 'db_conn.php';
	global $conn;
    $orgID = $_SESSION['orgID'];
    

	
	$name = $_POST['name'];
	$position = $_POST['position'];
	$filename = $_FILES['file']['name'];
	$tmpName = $_FILES["file"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    $imageSize = $_FILES[$name]["size"];

    if (!in_array($imageExtension, $validImageExtension)) {
        return "Invalid Image Extension";
    } elseif ($imageSize > 1200000) { // Validate the image size
        return "Image Size Is Too Large";
    }

	
	$newfilename = $name . "-" . $filename;

	move_uploaded_file($tmpName, 'img/RSO_image/' . $newfilename);

	$query = "INSERT INTO officertable(orgID, officer_name, officer_position, image_path) VALUES('$orgID', '$name', '$position', '$newfilename')";
    mysqli_query($conn, $query);

    logActivity($orgID, $date, 'Add', 'User added officer'.''.$name , $time);

    echo "
    <script> alert('User Added Successfully'); document.location = 'officers.php'</script> "; 

}

function edit(){
    include 'db_conn.php';
    global $conn;
    $orgID = $_SESSION['orgID'];
    
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    if ($_FILES["file"]["error"] != 4) {
        $filename = $_FILES["file"]["name"];
        $tmpName = $_FILES["file"]["tmp_name"];

        $newfilename = $name . "-" . $filename;

        move_uploaded_file($tmpName, 'img/RSO_image/' . $newfilename);

        $query = "UPDATE officertable SET image_path = '$newfilename' WHERE officerID = '$id'";
        mysqli_query($conn, $query);
    }

    $query = "UPDATE officertable set officer_name = '$name', officer_position = '$position' WHERE officerID = '$id'";
    mysqli_query($conn, $query);

    logActivity($orgID, $date, 'Update', 'User updated officer'.''.$name , $time);

    echo "<script> alert('Officer Edit Successfully'); document.location = 'file_upload.php'</script>";

}

function delete(){
    include 'db_conn.php';
    global $conn;
    $orgID = $_SESSION['orgID'];

	$id = $_POST["submit"];
	
	$query = "DELETE FROM officertable where officerID = '$id'";
	mysqli_query($conn, $query);
    
    logActivity($orgID, $date, 'Delete', 'User deleted officer', $time);

echo "
 <script> alert('Officer Delete Successfully'); document.location = 'file_upload.php'</script> "; 


}