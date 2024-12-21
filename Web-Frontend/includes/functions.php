<?php
require 'config.php';

function createAlertBadgeURL() {
    $text = $_GET['text'];
    $status = $_GET['status'];
    createAlertBadge($text, $status);
}


function createAlertBadge($text, $status) {

    if($status == "success") {
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?php echo $text;?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
    }

    if($status == "error") {
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?php echo $text;?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
    }
}

function slack($txt) {
    if(getConfig('SlackEnabled') == 1) {
        $msg = array('text' => $txt);
        $c = curl_init(getConfig('SlackWebhookURL'));
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, array('payload' => json_encode($msg)));
        curl_exec($c);
        curl_close($c);
    }
}

function dbInputSlackNotification($devID, $humidity, $temperature1, $temperature2) {
    $db_connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME) or die(mysql_error());
    $devices = mysqli_query($db_connect, "Select * from sensor where dev_id='$devID'");
    $data_row = mysqli_fetch_array($devices);
    echo $data_row['dev_place'];
    
    if($humidity > getConfig('SlackThreesholdHum')) {
        slack($data_row['dev_type'] . " ". $data_row['dev_place']. " hat festgestellt, dass die Luftfeuchtigkeit " . $humidity ."% beträgt - Bitte lüften!");
    }

    if($temperature1 > getConfig('SlackThreesholdTemp')) {
        slack($data_row['dev_type'] . " ". $data_row['dev_place']. " hat festgestellt, dass die Temperatur " . $temperature1 ." Grad Celsius beträgt!");
    }

    if($temperature2 > getConfig('SlackThreesholdTemp')) {
        slack($data_row['dev_type'] . " ". $data_row['dev_place']. " hat festgestellt, dass die Temperatur " . $temperature2 ." Grad Celsius beträgt!");
    }
}

function getStartAndEndDate($week, $year) {
    $dto = new DateTime();
    $dto->setISODate($year, $week);
    $ret['week_start'] = $dto->format('Y-m-d');
    $dto->modify('+6 days');
    $ret['week_end'] = $dto->format('Y-m-d');
    return $ret;
}

function getConfig($searchValue) {
    $db_connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME) or die(mysql_error());
    $sqlResponses = mysqli_query($db_connect, "SELECT * FROM config WHERE configname = '$searchValue'");
    foreach ($sqlResponses as $sqlResponse){
        $value = $sqlResponse['value'];
    }
    return $value;
}

?>