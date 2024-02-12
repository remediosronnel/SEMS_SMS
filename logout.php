<?php 
include "db_conn.php";
session_start();


logActivity('0', $date, 'Logout', 'User logged out', $time);



session_unset();
session_destroy();

header("Location: index.php");