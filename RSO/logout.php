<?php 
session_start();
include "db_conn.php";

$orgID=$_SESSION['orgID'];

logActivity($orgID, $date, 'Logout', 'User logged out', $time);



session_unset();
session_destroy();

header("Location: index.php");
?>