<?php 
session_start(); 
include "db_conn.php";
date_default_timezone_set('Asia/Manila');
$date = date('m-d-Y');
$time = date('h:i:s');

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
		
		$sql = "SELECT * FROM ssgtable WHERE userName='$uname' AND passWord='$pass'";

		$result = mysqli_query($conn, $sql);



		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['userName'] === $uname && $row['passWord'] === $pass) {
            	$_SESSION['userName'] = $row['userName'];
            	$_SESSION['lastName'] = $row['lastName'];
            	$_SESSION['ssgID'] = $row['ssgID'];
				$_SESSION['eventID'] = $row['eventID'];
				$_SESSION['orgID'] = $row['orgID'];

				logActivity($orgID, $date, 'Login', 'User logged in', $time);
				
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