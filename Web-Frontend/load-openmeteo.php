<?php 

require 'config.php';

$url = "https://api.open-meteo.com/v1/forecast?latitude=47.0321&longitude=8.4322&hourly=temperature_2m,relative_humidity_2m&forecast_days=1";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);

//$result = file_get_contents($url);
curl_close($curl);
// Will dump a beauty json :3
$values = json_decode($resp, true);
$time = $values["hourly"]["time"];
$temperature = $values["hourly"]["temperature_2m"];
$humidity = $values["hourly"]["relative_humidity_2m"];

$arrLength = count($time);
$sql = "";



// Check if Data exists


for ($i = 0; $i < $arrLength; $i++) {
    echo $i .": ". $time[$i];
    // Create connection
    $conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $query = "SELECT * FROM data_openmeteo WHERE datetime = '$time[$i]'";

    $result = $conn->query($query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo ' found!' ."<br>";
            $sql = ("UPDATE data_openmeteo SET temperature = '$temperature[$i]', humidity = '$humidity[$i]' WHERE datetime = '$time[$i]';");
            if ($conn->query($sql) === TRUE) {
              echo "Updated record successfully: ".$time[$i];
              echo "<br>";
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo ' not found'."<br>";
            $sql = ("INSERT INTO data_openmeteo (id, datetime, temperature, humidity) VALUES (NULL, '".$time[$i]."', '".$temperature[$i]."', '".$humidity[$i]."');");
            if ($conn->query($sql) === TRUE) {
              echo "New record created successfully: ".$time[$i];
              echo "<br>";
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo 'Error: ' . mysqli_error();
    }
    $conn->close();
    //$result = $conn->query("Select * from data_openmeteo WHERE datetime = ".$time[$i].";");


    /*

    */

}

?>