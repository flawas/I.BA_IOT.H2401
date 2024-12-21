<?php 

require("config.php");
$db_connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME) or die(mysql_error());
$devices = mysqli_query($db_connect, "Select * from sensor");

//create an array
$sensor = array();
while($row = mysqli_fetch_assoc($devices))
{
    $sensor[] = $row;
}
echo json_encode($sensor);

?>