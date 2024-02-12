<?php

$k = $_POST['id'];
$k = trim($k);
$con = mysqli_connect("127.0.0.1", "root", "", "lazaca");
$sql = "SELECT * FROM rsotable WHERE rsotable.orgName = '{$k}'";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result)) {
?>
     <tr>
         <td> <?php echo $row['contactNo']; ?> </td>
     </tr>
<?php
   
}
echo $sql;


?>