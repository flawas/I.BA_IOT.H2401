<?php 

require("config.php");
$db_connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME) or die(mysql_error());
$result = mysqli_query($db_connect, "Select * from data order by datetime DESC limit 500");

//create an array
$data = array();
while($row = mysqli_fetch_assoc($result))
{
    $data[] = $row;
}
echo json_encode($data);

?>