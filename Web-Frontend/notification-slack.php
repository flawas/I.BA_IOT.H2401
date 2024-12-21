<?php
require 'config.php';
include("includes/functions.php");

$db_connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME) or die(mysql_error());
$devices = mysqli_query($db_connect, "Select * from sensor");

$SlackThreesholdTemp = getConfig('SlackThreesholdTemp');
$SlackThreesholdHum = getConfig('SlackThreesholdHum');

echo "<br>";

foreach($devices as $device) {

    $dev_id = $device['dev_id'];
    $data = mysqli_query($db_connect, "SELECT * from data where dev_id='$dev_id' ORDER BY datetime DESC LIMIT 5");
    
    $temps1 = [];
    $temps2 = [];
    $hum = [];
    while($row = mysqli_fetch_array($data))
    {
        $rowdev = $row['dev_id'];
        $temps1[] = $row['dev_value_1'];
        $temps2[] = $row['dev_value_2'];
        $hum[] = $row['dev_value_3'];
    }

    $devices = mysqli_query($db_connect, "SELECT * from sensor WHERE dev_id='$rowdev'");
    $data_row = mysqli_fetch_array($devices);

    if($hum[0] > $hum[1] && $hum[0] > $SlackThreesholdHum) {
        $text = $data_row['dev_type'] . " ". $data_row['dev_place']. " stellt einen Anstieg der Luftfeuchtigkeit fest. Die Luftfeuchtigkeit beträgt aktuell " . $hum[0] ."%!";
        slack($text);
    }

    if($hum[0] < $hum[1] && $hum[0] > $SlackThreesholdHum) {
        $text = $data_row['dev_type'] . " ". $data_row['dev_place']. " stellt eine Verringerung der Luftfeuchtigkeit fest. Die Luftfeuchtigkeit beträgt aktuell " . $hum[0] ."%!";
        slack($text);
    }
    
    if($temps1[0] > $temps1[1] && $temps1[0] > $SlackThreesholdTemp) {
        $text = $data_row['dev_type'] . " ". $data_row['dev_place']. " stellt einen Anstieg der Temperatur fest. Die Temperatur beträgt aktuell " . $temps1[0] ." Grad Celsius!";
        slack($text);
    }

    if($temps1[0] < $temps1[1] && $temps1[0] > $SlackThreesholdTemp) {
        $text = $data_row['dev_type'] . " ". $data_row['dev_place']. " stellt eine Verringerung der Temperatur fest. Die Temperatur beträgt aktuell " . $temps1[0] ." Grad Celsius!";
        slack($text);
    }

    if($temps2[0] > $temps2[1] && $temps2[0] > $SlackThreesholdTemp) {
        $text = $data_row['dev_type'] . " ". $data_row['dev_place']. " stellt einen Anstieg der Temperatur fest. Die Temperatur beträgt aktuell " . $temps2[0] ." Grad Celsius!";
        slack($text);
    }

    if($temps2[0] < $temps2[1] && $temps2[0] > $SlackThreesholdTemp) {
        $text = $data_row['dev_type'] . " ". $data_row['dev_place']. " stellt eine Verringerung der Temperatur fest. Die Temperatur beträgt aktuell " . $temps2[0] ." Grad Celsius!";
        slack($text);
    }
}