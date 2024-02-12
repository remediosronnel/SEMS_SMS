<?php 
session_start(); 

$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}


if (isset($_POST['uname']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

	if (empty($uname)) {
		header("Location: index.php?error=User Name is required");
	    exit();
	}else if(empty($pass)){
        header("Location: index.php?error=Password is required");
	    exit();
	}else{
		
		$sql = "SELECT * FROM studenttable WHERE userName='$uname' AND passWord='$pass'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['userName'] === $uname && $row['passWord'] === $pass) {
            	$_SESSION['userName'] = $row['userName'];
            	$_SESSION['lastName'] = $row['lastName'];
            	$_SESSION['studentID'] = $row['studentID'];
				$_SESSION['eventID'] = $rows['eventID'];
				$_SESSION['orgID'] = $rows['orgID'];
            	header("Location: home.php");
		        exit();
            }else{
				header("Location: index.php?error=Incorect User name or password");
		        exit();
			}
		}else{
			header("Location: index.php?error=Incorect User name or password");
	        exit();
		}
	}
	
}else{
	header("Location: index.php");
	exit();
}