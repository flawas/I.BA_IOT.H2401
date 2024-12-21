
<?php 

require '../config.php';

// Create connection
$db_connect = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

$endDeviceID = $_POST['endDeviceID'];
$endDevicePlace = $_POST['endDevicePlace'];
$endDeviceType = $_POST['endDeviceType'];
$endDeviceManufacturer = $_POST['endDeviceManufacturer'];
$endDeviceModel = $_POST['endDeviceModel'];
$endDeviceModelValue1 = $_POST['endDeviceModelValue1'];
$endDeviceModelValueName1 = $_POST['endDeviceModelValueName1'];
$endDeviceModelValue2 = $_POST['endDeviceModelValue2'];
$endDeviceModelValueName2 = $_POST['endDeviceModelValueName2'];
$endDeviceModelValue3 = $_POST['endDeviceModelValue3'];
$endDeviceModelValueName3 = $_POST['endDeviceModelValueName3'];

$sql = ("INSERT INTO `sensor` (`id`, `dev_id`, `dev_place`, `dev_type`, `dev_brand`, `dev_model`, `value_1`, `value_1_name`, `value_2`, `value_2_name`, `value_3`, `value_3_name`, 
  `displayWeather`) VALUES (NULL, '$endDeviceID', '$endDevicePlace', 'endDeviceType', 'endDeviceManufacturer', 'endDeviceModel', '$endDeviceModelValue1', 
  '$endDeviceModelValueName1', '$endDeviceModelValue2', '$endDeviceModelValueName2','$endDeviceModelValue3', '$endDeviceModelValueName3', NULL);");

if ($db_connect->query($sql) === TRUE) {
  echo "New record created successfully";
  header('Location: ../device-add.php?text=Sensor erfolgreich hinzugefügt!&status=success');
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
  header('Location: ../device-add.php?text=Fehler im Formular. Sensor wurde nicht hinzugefügt!&status=error');
}

?>