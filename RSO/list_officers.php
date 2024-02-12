<?php
session_start();

// Establish database connection
$sname = "127.0.0.1";
$uname = "root";
$password = "";
$db_name = "lazaca";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the session variable orgID is set
if (!isset($_SESSION['orgID'])) {
    // Handle the case when orgID is not set
    exit("orgID is not set in the session.");
}
$orgID = $_SESSION['orgID'];

// Select the data for the president from the database
$sql = "SELECT * FROM officertable WHERE orgID = '$orgID' ";
$result = $conn -> query($sql);


// Check if any rows were returned
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $presName = $row["pres_name"];
    $presImage = $row["pres_image"];
    $VName = $row["v_pres_name"];
    $VImage = $row["v_pres_image"];
    $SecName = $row["sec_name"];
    $SecImage = $row["sec_image"];
    $TreasName = $row["treas_name"];
    $TreasImage = $row["treas_image"];
    $BusMngrName = $row["bus_mngr_name"];
    $BusMngrImage = $row["bus_mngr_image"];
    $PIOName = $row["pio_name"];
    $PIOImage = $row["pio_image"];

    // Display officer information with flexbox layout

    echo "<h1> SET OF OFFICERS </h1>";


    echo "<div style='display: flex; flex-direction: row; align-items: center;'>";
    echo "<div style='margin-right: 20px;'>";
    echo "<img src='$presImage' alt='President' style='width: 130px; height: 100px;' >";
    echo "<h5>PRESIDENT <br> $presName</h5>";
    echo "</div>";

    echo "<div style='margin-right: 20px;'>";
    echo "<img src='$VImage' alt='Vice President' style='width: 130px; height: 100px;' >";
    echo "<h5>VICE PRESIDENT <br> $VName</h5>";
    echo "</div>";

    echo "<div style='margin-right: 20px;'>";
    echo "<img src='$SecImage' alt='Secretary' style='width: 130px; height: 100px;' >";
    echo "<h5>SECRETARY <br> $SecName</h5>";
    echo "</div>";

    echo "<div style='margin-right: 20px;'>";
    echo "<img src='$TreasImage' alt='Treasurer' style='width: 130px; height: 100px;' >";
    echo "<h5>TREASURER <br> $TreasName</h5>";
    echo "</div>";

    echo "<div style='margin-right: 20px;'>";
    echo "<img src='$BusMngrImage' alt='Business Manager' style='width: 130px; height: 100px;' >";
    echo "<h5>BUSINESS MANAGER <br> $BusMngrName</h5>";
    echo "</div>";

    echo "<div>";
    echo "<img src='$PIOImage' alt='PIO' style='width: 130px; height: 100px;' >";
    echo "<h5>PIO <br> $PIOName</h5>";
    echo "</div>";
    echo "</div>";
    
    // Add button back to main menu
    echo "<a class='btn btn-primary' href='home.php'>BACK</a>";
} else {
    echo "No officers found for this organization.";
}

// Close statement and connection
$conn->close();
